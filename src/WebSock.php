<?php
namespace PixelWar;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use mysqli;

class WebSock implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
        $data = json_decode($msg);
        $x = $data->x;
        $y = $data->y;
        $color = $data->color;
        $sqlCheck = "SELECT 1 FROM Canvas WHERE X='$x' AND Y='$y' LIMIT 1";

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pixelwar";
    
        $conn = new mysqli($servername,$username,$password,$dbname);
        if($conn->connect_error){
            echo "Connection error : ".$conn->connect_error;
        }
        else{
            $res = $conn->query($sqlCheck);
            if(!$res){
                echo "An error occured. ".$sqlCheck;
                return;
            }
            else if($res->num_rows == 0){
                $sql = "INSERT INTO CANVAS (X,Y,Color) VALUES ($x,$y,'$color')";
            }
            else{
                $sql = "UPDATE CANVAS SET Color = '$color' WHERE X=$x AND Y=$y";
            }
            $conn->query($sql);
        }

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
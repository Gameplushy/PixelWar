<!DOCTYPE html>
<html>
    <head>
        <title>PixelWar WebSocket testing</title>
        <script>
            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
                console.log(e.data);
                data = JSON.parse(e.data);
                if(Array.isArray(data))
                    generatePainting(data)
                else paintCanvas(data)
            }

            function sendNewPixel(){
                const x = document.getElementById("x").value
                const y = document.getElementById("y").value
                const color = document.getElementById("chosenColor").value
                const res = {
                    "X" : x,
                    "Y" : y,
                    "Color" : color
                }
                console.log(res)
                conn.send(JSON.stringify(res));
                paintCanvas(res);
            }

            function paintCanvas(pixel){
                const canvas = document.getElementById("res");
                const context = canvas.getContext("2d")
                console.log(pixel.X)
                context.fillStyle = pixel.Color || '#000';
                context.fillRect(pixel.X,pixel.Y,1,1)
            }

            function generatePainting(data){
                data.forEach(pixel => {
                    console.log(pixel)
                    paintCanvas(pixel);
                });
            }
        </script>
    </head>
    <body>
        <input type="color" id="chosenColor">
        <input type="number" id="x">
        <input type="number" id="y">
        <button onclick="sendNewPixel()">Send pixel!</button>

        <div>
            <canvas id="res" height="700px" width="1000px"></canvas>
        </div>

    </body>
</html>
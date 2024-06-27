<?php
include 'config.php';
include 'auth.php';
include 'pages/header.php';

// Fetch user data if needed
// Example: $result = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."'");

?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Pickup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Input Data Pickup Agen</h1>
        <form action="insert_agen.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="lokasi_id" class="form-label">ID AGEN</label>
                <input type="text" class="form-control" id="lokasi_id" name="lokasi_id" readonly required>
                <button type="button" class="btn btn-primary mt-2" onclick="scanQRCode()">Scan QR Code</button>
            </div>
            <div id="reader" style="width: 300px;"></div>
            <div class="form-row">
                <div class="form-group col-md-2">
                <label for="date_pickup">Tgl Pickup</label>
                <input type="text" class="form-control" id="date_pickup" name="date_pickup" readonly required>
                </div>
                <div class="form-group col-md-2">
                <label for="time_pickup">Jam Pickup</label>
                <input type="text" class="form-control" id="time_pickup" name="time_pickup" readonly required>
                </div>
                <div class="form-group col-md-3">
                <label for="pic_pickup">Driver</label>
                <input type="text" class="form-control" value='<?php echo $_SESSION['username']; ?>' id="pic_pickup" name="pic_pickup" readonly required>
                </div>
            </div>
            <div class="mb-3">
                <input type='hidden' class="form-control" value='PROGRESS PICKUP' id="pik_status" name="pik_status" required> 
            </div>
            <div class="mb-3">
                <label for="connote" class="form-label">Jumlah Connote</label>
                <input type="number" class="form-control" id="connote" name="connote" required>
            </div>
            <div class="mb-3">
                <label for="koli" class="form-label">Jumlah Koli</label>
                <input type="number" step="0.1" class="form-control" id="koli" name="koli" required>
            </div>
            <div class="mb-3">
                <label for="photo1" class="form-label">Foto</label>
                <video id="video" width="320" height="240" autoplay></video>
                <button type="button" class="btn btn-secondary mt-2" onclick="takePhoto()">Ambil Foto</button>
                <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                <img id="photo-preview" src="" class="mt-3" style="display:none;">
                <input type="hidden" id="photo1" name="photo1">
            </div>
            <div class="mb-3">
                <label for="signature1" class="form-label">Tanda Tangan</label>
                <canvas id="signature-pad" class="border" width="400" height="200"></canvas>
                <button type="button" class="btn btn-secondary mt-2" onclick="clearSignature()">Clear</button>
                <input type="hidden" id="signature1" name="signature1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        function scanQRCode() {
            const html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: 250
                },
                qrCodeMessage => {
                    document.getElementById("lokasi_id").value = qrCodeMessage;
                    html5QrCode.stop().then(ignore => {}).catch(err => console.log(err));
                }
            ).catch(err => console.log(err));
        }

        function setDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const formattedDate = `${year}-${month}-${day}`;
            const formattedTime = `${hours}:${minutes}:${seconds}`;

            document.getElementById("date_pickup").value = formattedDate;
            document.getElementById("time_pickup").value = formattedTime;
        }
        window.onload = setDateTime;

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const photoInput = document.getElementById('photo1');
        const photoPreview = document.getElementById('photo-preview');
        const signaturePad = new SignaturePad(document.getElementById('signature-pad'));

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.play();
            })
            .catch(err => console.error("Error accessing camera: " + err));

        function takePhoto() {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');
            photoInput.value = dataURL;
            photoPreview.src = dataURL;
            photoPreview.style.display = 'block';
        }

        function clearSignature() {
            signaturePad.clear();
        }

        document.querySelector('form').addEventListener('submit', (event) => {
            if (signaturePad.isEmpty()) {
                alert("Tanda tangan diperlukan.");
                event.preventDefault();
            } else {
                const dataURL = signaturePad.toDataURL();
                document.getElementById('signature1').value = dataURL;
            }
        });
    </script>
</body>
</html>


          <!-- DataTales Example -->


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php 
include 'pages/footer.php';
?>
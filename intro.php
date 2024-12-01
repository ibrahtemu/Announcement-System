<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: loginpage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intro Animation</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset some default browser styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }      
        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #282c34;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        .intro {
            text-align: center;
            color: #61dafb;
        }
        /* Typewriter Effect Styles */
        #intro-title {
            font-size: 4rem;
            color: #61dafb;
            font-family: 'Courier New', Courier, monospace;
            white-space: nowrap;
            overflow: hidden;
            border-right: 0.15em solid #61dafb;
            box-sizing: border-box;
            margin: 0 auto;
        }

        /* Blinking Cursor Animation */
        @keyframes blinkCursor {
            from { border-right-color: #61dafb; }
            to { border-right-color: transparent; }
        }

        #intro-title {
            animation: blinkCursor 0.7s steps(44) infinite normal;
        }

        .progress-container {
            width: 80%;
            background: linear-gradient(90deg, #61dafb33, #282c34);
            border-radius: 25px;
            margin: 20px auto 0;
            overflow: hidden;
            height: 20px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.2);
            position: relative;
            display: none;
        }

        .progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #61dafb, #21a1f1);
            border-radius: 25px 0 0 25px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.3);
            background-size: 200% 100%;
            animation: progressPulse 2s infinite;
        }

        @keyframes progressPulse {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
    </style>
</head>
<body>
    <div class="intro">
        <h1 id="intro-title"></h1>
        <div class="progress-container" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar" id="progress-bar"></div>
        </div>
        <p>Loading...</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
    <script>
        function typeWriter(text, element, delay, callback) {
            let i = 0;
            function typing() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(typing, delay);
                } else if (callback) {
                    callback();
                }
            }
            typing();
        }

        window.addEventListener('DOMContentLoaded', () => {
            const introTitle = "ANNOUNCEMENTS SYSTEM";
            const headerElement = document.getElementById('intro-title');
            const progressBar = document.getElementById('progress-bar');
            const progressContainer = document.querySelector('.progress-container');
            const typewriterDelay = 100;
            const progressDuration = 5000;

            typeWriter(introTitle, headerElement, typewriterDelay, () => {
                progressContainer.style.display = 'block';

                gsap.to(progressBar, {
                    duration: progressDuration / 1000,
                    width: '100%',
                    ease: 'linear',
                    onComplete: () => {
                        // Redirect after animation completes
                        window.location.href = 'redirect.php'; // Redirect to the redirect page
                    }
                });
            });
        });
    </script>
</body>
</html>

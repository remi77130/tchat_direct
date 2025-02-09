<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salon VIP Créé</title>
  <style>
    body {
      margin: 0;
      overflow: hidden;
      background: #1e1e2f;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
      font-family: 'Arial', sans-serif;
    }

    .container {
      text-align: center;
      z-index: 10;
      position: relative;
    }

    h1 {
      font-size: 48px;
      color: #ffd700;
      text-shadow: 0 0 10px #ffd700, 0 0 20px #ff8c00, 0 0 30px #ffd700;
      margin-bottom: 10px;
      animation: glow 1s infinite alternate;
    }

    @keyframes glow {
      from {
        text-shadow: 0 0 10px #ffd700, 0 0 20px #ff8c00;
      }
      to {
        text-shadow: 0 0 20px #ffd700, 0 0 30px #ff8c00;
      }
    }

    p {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .button-container {
      margin-top: 20px;
    }

    .button {
      padding: 12px 30px;
      font-size: 16px;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(90deg, #ff5722, #ff9800);
      border: none;
      border-radius: 30px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .button:hover {
      background: linear-gradient(90deg, #ff9800, #ff5722);
      transform: scale(1.1);
    }

    canvas {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Félicitations !</h1>
    <p>Votre salon VIP est maintenant <span style="color: #ffd700; font-weight: bold;">créé</span> ! <br>
    Une nouvelle aventure prestigieuse commence.</p>
    <div class="button-container">
      <button class="button" onclick="alert('Partager le salon')">Partager le Salon</button>
    </div>
  </div>

  <canvas></canvas>

  <script>
    const canvas = document.querySelector('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const particles = [];

    class Particle {
      constructor(x, y, color) {
        this.x = x;
        this.y = y;
        this.color = color;
        this.size = Math.random() * 5 + 2;
        this.speedX = Math.random() * 4 - 2;
        this.speedY = Math.random() * 4 - 2;
        this.alpha = 1;
      }

      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        this.alpha -= 0.02;
        if (this.alpha < 0) this.alpha = 0;
      }

      draw() {
        ctx.globalAlpha = this.alpha;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.fill();
      }
    }

    function createParticles(x, y) {
      for (let i = 0; i < 50; i++) {
        particles.push(new Particle(x, y, `hsl(${Math.random() * 360}, 100%, 50%)`));
      }
    }

    function animateParticles() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particles.forEach((particle, index) => {
        particle.update();
        particle.draw();
        if (particle.alpha === 0) particles.splice(index, 1);
      });
      requestAnimationFrame(animateParticles);
    }

    // Explosion initiale au centre de l'écran
    createParticles(canvas.width / 2, canvas.height / 2);

    // Explosion lorsqu'on clique
    window.addEventListener('click', (e) => {
      createParticles(e.clientX, e.clientY);
    });

    animateParticles();

    // Ajouter un son festif
    const audio = new Audio('https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3'); // Son festif
    audio.volume = 0.5;
    audio.play();
  </script>
</body>
</html>

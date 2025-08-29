<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Scan Nutrition</title>
  <style>
    :root { --bg:#0f172a; --card:#111827; --text:#e5e7eb; --muted:#9ca3af; --accent:#22d3ee; }
    *{box-sizing:border-box} body{margin:0;font-family:system-ui,Segoe UI,Roboto,Helvetica,Arial;background:linear-gradient(180deg,#0b1220,#0f172a)}
    header{padding:16px 20px;color:var(--text);text-align:center;border-bottom:1px solid #1f2937}
    h1{margin:0;font-size:22px;letter-spacing:.5px}
    main{max-width:900px;margin:0 auto;padding:16px}
    .grid{display:grid;gap:16px}
    @media(min-width:900px){.grid{grid-template-columns: 1.1fr .9fr}}
    .card{background:var(--card);border:1px solid #1f2937;border-radius:16px;padding:14px;box-shadow:0 10px 30px rgba(0,0,0,.25)}
    .row{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    button, input[type="text"]{padding:10px 12px;border-radius:10px;border:1px solid #334155;background:#0b1220;color:var(--text)}
    button{cursor:pointer}
    button.primary{background:var(--accent);color:#0b1220;border:0;font-weight:700}
    video{width:100%;border-radius:12px;background:#000;aspect-ratio:16/9;object-fit:cover;border:1px solid #1f2937}
    .badge{display:inline-block;padding:4px 8px;border-radius:999px;background:#0b1220;border:1px solid #334155;color:var(--muted);font-size:12px}
    .title{font-weight:700;color:var(--text);margin:6px 0 2px}
    .muted{color:var(--muted);font-size:14px}
    .nutri{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px}
    .nutri div{background:#0b1220;border:1px solid #1f2937;border-radius:10px;padding:10px}
    .error{color:#fca5a5}
    footer{color:var(--muted);text-align:center;padding:18px;font-size:12px}
  </style>
</head>
<body>
  <header>
    <h1>🥗 Scan Nutrition</h1>
    <div class="muted">Scanne un code-barres pour voir la valeur nutritionnelle</div>
  </header>

  <main class="grid">
    <!-- Colonne caméra / scan -->
    <section class="card">
      <div class="row" style="justify-content:space-between;margin-bottom:8px">
        <div class="row">
          <button id="startBtn" class="primary">🎥 Activer la caméra</button>
          <button id="stopBtn">⏹️ Stop</button>
        </div>
        <span id="detectorType" class="badge">Scanner : inconnu</span>
      </div>

      <video id="preview" playsinline></video>

      <div class="row" style="margin-top:10px">
        <input id="manualInput" type="text" placeholder="Ou saisis un EAN (ex: 3017620422003)" />
        <button id="manualBtn">🔎 Rechercher</button>
      </div>
      <div id="scanStatus" class="muted" style="margin-top:8px"></div>
    </section>

    <!-- Colonne résultat -->
    <section class="card" id="resultCard">
      <div class="title">Résultat</div>
      <div id="result" class="muted">Aucun produit scanné.</div>
    </section>
  </main>

  <footer>
    Données: Open Food Facts • Aucune donnée perso envoyée, tout reste sur ton appareil (hors appel API).
  </footer>

  <!-- Fallback ZXing (utilisé si BarcodeDetector indisponible) -->
  <script src="https://unpkg.com/@zxing/library@0.20.0"></script>
  <script>
    const video = document.getElementById('preview');
    const startBtn = document.getElementById('startBtn');
    const stopBtn = document.getElementById('stopBtn');
    const resultDiv = document.getElementById('result');
    const statusDiv = document.getElementById('scanStatus');
    const manualBtn = document.getElementById('manualBtn');
    const manualInput = document.getElementById('manualInput');
    const detectorType = document.getElementById('detectorType');

    let stream = null;
    let scanning = false;
    let barcodeDetector = null;
    let zxingReader = null;
    let zxingInterval = null;

    async function getProduct(barcode) {
      statusDiv.textContent = "Recherche du produit…";
      try {
        const resp = await fetch(`https://world.openfoodfacts.org/api/v2/product/${barcode}.json`);
        const data = await resp.json();
        if (!data || !data.product) {
          throw new Error("Produit non trouvé");
        }
        renderProduct(data.product, barcode);
        statusDiv.textContent = "OK";
      } catch (e) {
        resultDiv.innerHTML = `<span class="error">Produit introuvable pour EAN ${barcode}.</span>`;
        statusDiv.textContent = e.message;
      }
    }

    function renderProduct(p, ean) {
      const name = p.product_name || "(nom inconnu)";
      const brand = (p.brands || "").split(",")[0]?.trim() || "—";
      const img = p.image_small_url || p.image_url || "";
      const nutr = p.nutriments || {};
      const kcal = nutr["energy-kcal_100g"] ?? nutr["energy-kcal"] ?? nutr["energy_100g"] ?? "—";
      const fat = nutr["fat_100g"] ?? "—";
      const sat = nutr["saturated-fat_100g"] ?? "—";
      const carb = nutr["carbohydrates_100g"] ?? "—";
      const sugar = nutr["sugars_100g"] ?? "—";
      const prot = nutr["proteins_100g"] ?? "—";
      const salt = nutr["salt_100g"] ?? "—";
      const ns = p.nutriscore_grade ? p.nutriscore_grade.toUpperCase() : "—";

      resultDiv.innerHTML = `
        <div class="row" style="align-items:flex-start">
          <img src="${img}" alt="" style="width:72px;height:72px;border-radius:10px;object-fit:cover;border:1px solid #1f2937" onerror="this.style.display='none'"/>
          <div>
            <div class="title">${name}</div>
            <div class="muted">${brand} • EAN ${ean} • Nutri-Score <span class="badge">${ns}</span></div>
          </div>
        </div>
        <div class="nutri">
          <div><strong>Énergie (kcal/100g)</strong><br>${kcal}</div>
          <div><strong>Graisses /100g</strong><br>${fat} g</div>
          <div><strong>Graisses sat. /100g</strong><br>${sat} g</div>
          <div><strong>Glucides /100g</strong><br>${carb} g</div>
          <div><strong>Sucres /100g</strong><br>${sugar} g</div>
          <div><strong>Protéines /100g</strong><br>${prot} g</div>
          <div><strong>Sel /100g</strong><br>${salt} g</div>
          <div><strong>Allergènes</strong><br>${(p.allergens_tags || []).map(a=>a.replace('en:','')).join(', ') || '—'}</div>
        </div>
        <div style="margin-top:10px" class="muted">
          <a href="https://world.openfoodfacts.org/product/${ean}" target="_blank" rel="noopener">Voir la fiche complète</a>
        </div>
      `;
    }

    async function startCamera() {
      try {
        stream = await navigator.mediaDevices.getUserMedia({
          video: { facingMode: 'environment' }, audio: false
        });
        video.srcObject = stream;
        await video.play();
      } catch (e) {
        statusDiv.textContent = "Autorise l'accès à la caméra.";
        throw e;
      }
    }

    function stopCamera() {
      if (stream) {
        stream.getTracks().forEach(t => t.stop());
        stream = null;
      }
      if (zxingInterval) {
        clearInterval(zxingInterval);
        zxingInterval = null;
      }
      scanning = false;
    }

    async function startScan() {
      await startCamera();
      scanning = true;

      if ('BarcodeDetector' in window) {
        barcodeDetector = new window.BarcodeDetector({ formats: ['ean_13','ean_8','upc_a','upc_e'] });
        detectorType.textContent = "Scanner : BarcodeDetector (natif)";
        loopNative();
      } else {
        detectorType.textContent = "Scanner : ZXing (fallback)";
        zxingReader = new ZXing.BrowserMultiFormatReader();
        loopZXing();
      }
    }

    async function loopNative() {
      statusDiv.textContent = "Scanne en cours… place le code face à la caméra.";
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');

      const tick = async () => {
        if (!scanning || !video.videoWidth) return;
        canvas.width = video.videoWidth; canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        try {
          const barcodes = await barcodeDetector.detect(canvas);
          if (barcodes.length) {
            const raw = barcodes[0].rawValue;
            scanning = false; stopCamera();
            getProduct(raw);
            return;
          }
        } catch {}
        requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    }

    function loopZXing() {
      statusDiv.textContent = "Scanne en cours…";
      zxingInterval = setInterval(async () => {
        if (!scanning) return;
        try {
          const result = await zxingReader.decodeOnceFromVideoElement(video);
          if (result && result.text) {
            scanning = false; stopCamera();
            getProduct(result.text);
          }
        } catch { /* continue */ }
      }, 500);
    }

    // Events
    startBtn.addEventListener('click', () => startScan().catch(console.error));
    stopBtn.addEventListener('click', () => { scanning=false; stopCamera(); statusDiv.textContent="Arrêté."; });
    manualBtn.addEventListener('click', () => {
      const v = manualInput.value.replace(/\D/g,'');
      if (v.length >= 8) { getProduct(v); } else { statusDiv.textContent = "Saisis un EAN valide."; }
    });
  </script>
</body>
</html>

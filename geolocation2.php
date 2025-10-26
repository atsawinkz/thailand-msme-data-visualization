
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8"/>
<title>Thailand Drug Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Thai font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
  :root{
    --bg:#faf7f2; --card:#ffffff; --text:#1f2937; --muted:#6b7280; --border:#e5e7eb;
    --red:#b91c1c; --green:#059669; --ink:#0f172a;
  }
  html,body{height:100%; background:var(--bg); color:var(--text); font-family:"Noto Sans Thai",system-ui,-apple-system,Segoe UI,Roboto,Arial;}
  .app{
    display:grid;
    grid-template-columns: 320px 1fr 430px;
    grid-template-rows: auto 1fr;
    height:100vh; gap:12px;
  }
  .header{ grid-column:1/4; border-bottom:1px solid var(--border); background:linear-gradient(180deg,#fff,rgba(255,255,255,.6)); }
  .logo{width:40px;height:40px;border-radius:10px; object-fit:cover; border:1px solid var(--border);}
  .title{ font-weight:800; letter-spacing:.2px; color:var(--ink); }

  .left{ grid-column:1; grid-row:2; padding:0 12px 12px 12px; overflow:auto; }
  .panel,.cardish{ background:var(--card); border:1px solid var(--border); border-radius:14px; padding:12px; box-shadow:0 6px 18px rgba(15,23,42,.04); }
  .panel .form-label{ font-size:12px; margin-bottom:6px; color:var(--muted); }
  .cardish h6{ font-weight:700; margin-bottom:8px; }

  .center{ grid-column:2; grid-row:2; position:relative; }
  #mapid{ height:100%; width:100%; border-radius:14px; }
  .map-title{
    position:absolute; left:50%; top:12px; transform:translateX(-50%);
    background:rgba(255,255,255,.95); border:1px solid var(--border); border-radius:999px;
    padding:6px 14px; font-weight:700; box-shadow:0 6px 18px rgba(0,0,0,.05);
  }
  .info{ padding:8px 10px; font-size:14px; background:#fff; border:1px solid var(--border); border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,.06);}
  .legend{ background:#fff; border:1px solid var(--border); border-radius:10px; padding:10px 12px; font-size:13px; color:var(--text); box-shadow:0 8px 24px rgba(0,0,0,.06); }
  .legend i{ width:14px; height:14px; display:inline-block; margin-right:8px; border-radius:3px; vertical-align:-2px; }

  .right{ grid-column:3; grid-row:2; padding-right:12px; overflow:auto; display:flex; flex-direction:column; gap:12px; }

  .input-soft{ background:#fff; border:1px solid var(--border); }
  .btn-red{ background:var(--red); color:#fff; border:none; }
  .btn-red:hover{ filter:brightness(.96); }
  .muted{ color:var(--muted); }
  .subtle{ color:#475569; font-size:12px; }

  /* Loading overlay */
  #loading{
    position:fixed; inset:0; display:flex; align-items:center; justify-content:center;
    background:rgba(250,247,242,.65); z-index:9999; backdrop-filter:saturate(140%) blur(2px);
  }
  .spinner{ width:36px; height:36px; border-radius:999px; border:3px solid #e5e7eb; border-top-color:var(--red); animation:spin 1s linear infinite;}
  @keyframes spin{ to{ transform:rotate(360deg);} }
</style>
</head>
<body>
<div id="loading"><div class="spinner" aria-label="กำลังโหลด..."></div></div>

<div class="app">
  <!-- Header -->
  <div class="header">
    <div class="container-fluid py-2">
      <div class="d-flex align-items-center gap-3">
        <!-- FIX: ใช้ src แทน img= -->
        <img class="logo" src="Thailand Drug Offense.png" alt="Logo">
        <div class="title h1 mb-0">Thailand Drug Dashboard</div>
      </div>
    </div>
  </div>

  <!-- Left controls + Compare chart -->
  <aside class="left">
    <div class="panel mb-3">
      <label class="form-label" for="provSearch">ค้นหาจังหวัด</label>
      <div class="input-group input-group-sm mb-3">
        <input id="provSearch" class="form-control input-soft" placeholder="ค้นหาเป็นอังกฤษ">
        <button id="provBtn" class="btn btn-red">ค้นหา</button>
      </div>

      <label class="form-label" for="yearSel">เลือกปี</label>
      <select id="yearSel" class="form-select form-select-sm input-soft mb-3"></select>

      <label class="form-label" for="groupSel">เลือกกลุ่มข้อมูล</label>
      <select id="groupSel" class="form-select form-select-sm input-soft mb-3">
        <option value="คดี">คดี</option>
        <option value="ผู้ต้องสงสัย">ผู้ต้องสงสัย</option>
      </select>

      <label class="form-label" for="offenseSel">เลือกประเภทคดี</label>
      <select id="offenseSel" class="form-select form-select-sm input-soft"></select>

      <div class="mt-3 small muted" id="sumBadge">รวมทั้งประเทศ: - คดี</div>
      <div class="subtle mt-1" id="contextNote"></div>
    </div>

    <div class="cardish">
      <h6>เปรียบเทียบ คดี vs ผู้ต้องสงสัย (ต่อปี)</h6>
      <div id="compareChart" style="height:380px;"></div>
    </div>
  </aside>

  <!-- Center map -->
  <main class="center">
    <div id="mapid" aria-label="แผนที่จังหวัด"></div>
    <div class="map-title">Thailand Drug Dashboard (2017–2022)</div>
  </main>

  <!-- Right charts -->
  <section class="right">
    <div class="cardish">
      <h6>แนวโน้มรายปี (2017–2022)</h6>
      <div id="trendChart" style="height:360px;"></div>
    </div>
    <div class="cardish">
      <h6>Top 10 จังหวัดที่คดีมากที่สุด</h6>
      <div id="topProvChart" style="height:360px;"></div>
    </div>
  </section>
</div>

<!-- Libs -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>google.charts.load('current', {packages:['corechart','bar']});</script>

<script>
/* ===== 1) Files & schema ===== */
const POLY_URL = 'geoBoundaries_cleaned.geojson';
const DATA_URL = 'thai_drug_offenses_cleaned.json';
const COL = { year:'fiscal_year', prov:'province_en', offTh:'offense_th', offEn:'types_of_drug_offenses', val:'no_cases' };
const groupOf = s => String(s||'').startsWith('suspects_in_') ? 'ผู้ต้องสงสัย' : 'คดี';
const ALL_YEARS = [2017,2018,2019,2020,2021,2022];

const state = { year:'__ALL__', group:'คดี', offense:'__ALL__' };
let poly=null, rows=[], map=null, geojsonLayer=null, info=null;

/* ===== 2) Helpers ===== */
const norm = s=> String(s||'').trim().toLowerCase();
async function loadJSON(u){ const r=await fetch(u+'?ts='+Date.now(),{cache:'no-store'}); if(!r.ok) throw new Error(u); return r.json(); }
function detectPolyNameKey(){
  if(!poly?.features?.length) return 'name';
  const p = poly.features[0].properties || {};
  if('province_en' in p) return 'province_en';
  if('name' in p) return 'name';
  return Object.keys(p).find(k=>/name|shape/i.test(k)) || 'name';
}

// alias ป้องกันสะกดต่างกันเล็กน้อย
const PROV_ALIAS = new Map([
  ['buengkan','bueng kan'],
  ['bueng kan province','bueng kan'],
  ['nongkhai','nong khai'],
  ['nong khai province','nong khai'],
  ['bangkok metropolis','bangkok'],
  ['krung thep maha nakhon','bangkok']
]);
function normalizeProvKey(s){
  let k = norm(s).replace(/\s+/g,' ').trim();
  if (PROV_ALIAS.has(k)) k = PROV_ALIAS.get(k);
  return k;
}

/* ===== 3) Filters ===== */
function refreshYearOptions(){
  const yearSet = new Set(rows.map(r=>+r[COL.year]).filter(Boolean));
  yearSel.innerHTML = `<option value="__ALL__">ทั้งหมด</option>` + ALL_YEARS.filter(y=>yearSet.has(y)).map(y=>`<option value="${y}">${y}</option>`).join('');
  yearSel.value = state.year;
}
function refreshOffenseOptions(){
  const set = new Set();
  rows.forEach(r=>{
    if(state.year!=='__ALL__' && +r[COL.year]!==+state.year) return;
    if(state.group!==groupOf(r[COL.offEn])) return;
    const x = String(r[COL.offTh]||'').trim(); if(x) set.add(x);
  });
  offenseSel.innerHTML = `<option value="__ALL__">ทั้งหมด</option>` + [...set].sort().map(o=>`<option>${o}</option>`).join('');
  offenseSel.value = set.has(state.offense)? state.offense : '__ALL__';
}

/* ===== 4) Fixed axes ===== */
let GLOBAL_TREND_Y_MAX = 0;
let GLOBAL_PROV_X_MAX  = 0;
let GLOBAL_COMPARE_Y_MAX = 0;

function precomputeFixedScales(){
  const sumByYear = (wantGroup) => ALL_YEARS.map(y=>{
    let s=0; rows.forEach(r=>{ if(+r[COL.year]===y && wantGroup===groupOf(r[COL.offEn])) s += (+r[COL.val]||0); }); return s;
  });
  const maxCases    = Math.max(...sumByYear('คดี'), 0);
  const maxSuspects = Math.max(...sumByYear('ผู้ต้องสงสัย'), 0);
  GLOBAL_TREND_Y_MAX = Math.ceil(Math.max(maxCases, maxSuspects) * 1.05) || 10;

  const byProv = new Map();
  rows.forEach(r=>{ const k=normalizeProvKey(r[COL.prov]); byProv.set(k,(byProv.get(k)||0) + (+r[COL.val]||0)); });
  GLOBAL_PROV_X_MAX = Math.ceil(Math.max(...byProv.values(), 0) * 1.05) || 10;

  let cmpMax = 0;
  ALL_YEARS.forEach(y=>{
    let c=0,s=0;
    rows.forEach(r=>{
      if(+r[COL.year]!==y) return;
      if(groupOf(r[COL.offEn])==='คดี') c += (+r[COL.val]||0);
      else s += (+r[COL.val]||0);
    });
    cmpMax = Math.max(cmpMax, c, s);
  });
  GLOBAL_COMPARE_Y_MAX = Math.ceil(cmpMax * 1.05) || 10;
}

/* ===== 5) Aggregations ===== */
function sumByProvince(){
  const m=new Map();
  rows.forEach(r=>{
    if(state.year!=='__ALL__' && +r[COL.year]!==+state.year) return;
    if(state.group!==groupOf(r[COL.offEn])) return;
    if(state.offense!=='__ALL__' && String(r[COL.offTh]).trim()!==state.offense) return;
    const k = normalizeProvKey(r[COL.prov]);
    const v = +r[COL.val]||0;
    m.set(k,(m.get(k)||0)+v);
  });
  return m;
}
function totalByYear_filteredGroup(){
  return ALL_YEARS.map(y=>{
    let s=0;
    rows.forEach(r=>{
      if(+r[COL.year]!==y) return;
      if(state.group!==groupOf(r[COL.offEn])) return;
      if(state.offense!=='__ALL__' && String(r[COL.offTh]).trim()!==state.offense) return;
      s += (+r[COL.val]||0);
    });
    return s;
  });
}

/* ===== 6) Map ===== */
function colorFor(d){
  return  d > 100000 ? '#800026' :
          d >  50000 ? '#BD0026' :
          d >  20000 ? '#E31A1C' :
          d >  10000 ? '#FC4E2A' :
          d >   5000 ? '#FD8D3C' :
          d >   2000 ? '#FEB24C' :
          d >      0 ? '#FED976' :
                       '#FFEDA0';
}

// NOTE: เส้นปะทำให้ดู “ไม่แข็ง” เกินไป และใช้ lineJoin/lineCap round ให้โค้งมน
function style(feature){
  return {
    fillColor:colorFor(feature.properties.value),
    weight:1.2,
    color:'#ffffff',
    dashArray:'2,4',          // ลายปะสั้น เนียนตา
    lineJoin:'round',
    lineCap:'round',
    fillOpacity:.92,
    opacity:.9
  };
}

function buildGeoForLeaflet(){
  const cloned = JSON.parse(JSON.stringify(poly||{})); if(!cloned?.features?.length) return null;
  const key=detectPolyNameKey(), sums=sumByProvince(); let total=0;

  cloned.features.forEach(ft=>{
    const props=ft.properties||{};
    const label = String(props[key] ?? props.name ?? props.province_en ?? '').trim();
    const kk = normalizeProvKey(label);
    const v = sums.get(kk) || 0;
    props.name  = label;
    props.value = v;
    ft.properties = props;
    total += v;
  });

  const unit = (state.group === 'ผู้ต้องสงสัย') ? 'ผู้ต้องสงสัย' : 'คดี';
  sumBadge.textContent = `รวมทั้งประเทศ: ${total.toLocaleString('th-TH')} ${unit}`;
  contextNote.textContent = `ตัวกรอง: ${state.group}${state.offense!=='__ALL__' ? ' • ประเภทคดี: '+state.offense : ''}${state.year!=='__ALL__' ? ' • ปี: '+state.year : ' • ทุกปี'}`;
  return cloned;
}

function initMap(){
  map = L.map('mapid', { zoomControl:true }).setView([16.5,101],6);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution:'© OpenStreetMap'}).addTo(map);

  info = L.control();
  info.onAdd = function(){ this._div=L.DomUtil.create('div','info'); this.update(); return this._div; };
  info.update = function(p){ this._div.innerHTML = `<strong>Thailand Drug Offenses</strong><br>${p?`<b>${p.name}</b><br>${(p.value||0).toLocaleString('th-TH')} คดี`:'เลื่อนเมาส์เพื่อดูข้อมูล'}`; };
  info.addTo(map);

  const legend = L.control({position:'bottomleft'});
  legend.onAdd = function(){
    const div=L.DomUtil.create('div','legend'); const b=[0,2000,5000,10000,20000,50000,100000];
    div.innerHTML=b.map((v,i)=>`<div><i style="background:${colorFor(v+1)}"></i>${v.toLocaleString('th-TH')}${b[i+1]?'–'+b[i+1].toLocaleString('th-TH'):'+'}</div>`).join('');
    return div;
  };
  legend.addTo(map);
}

function drawMap(){
  const geo = buildGeoForLeaflet(); if(!geo) return;
  if(geojsonLayer) map.removeLayer(geojsonLayer);
  geojsonLayer = L.geoJson(geo,{
    style,
    smoothFactor:0.25,      // ทำเส้นโค้งมนขึ้น
    renderer:L.canvas(),    // เร็วและเนียนขึ้นบนเครื่องส่วนใหญ่
    onEachFeature:(ft,l)=>{
      l.on({
        mouseover:e=>{ const x=e.target; x.setStyle({weight:2.2,color:'#111827',dashArray:''}); info.update(x.feature.properties); },
        mouseout:e=>{ geojsonLayer.resetStyle(e.target); info.update(); },
        click:e=> map.fitBounds(e.target.getBounds(), {padding:[8,8]})
      });
    }
  }).addTo(map);
  try{ map.fitBounds(geojsonLayer.getBounds(), {padding:[8,8]}); }catch(e){}
}

/* ===== 7) Charts ===== */
function drawTrend(){
  const totals = totalByYear_filteredGroup();
  const dt = new google.visualization.DataTable();
  dt.addColumn('number','ปี');
  dt.addColumn('number','จำนวน');
  ALL_YEARS.forEach((y,i)=> dt.addRow([y, totals[i]||0]));

  const opt = {
    backgroundColor:'transparent',
    legend:'none',
    hAxis:{ ticks: ALL_YEARS, gridlines:{ color:'#f3f4f6' } },
    vAxis:{ viewWindow:{min:0, max:GLOBAL_TREND_Y_MAX}, format:'short', gridlines:{ color:'#e5e7eb' } },
    colors:['#b91c1c'],
    pointSize:4,
    curveType:'function',
    chartArea:{left:60,right:16,top:16,bottom:40}
  };
  new google.visualization.LineChart(document.getElementById('trendChart')).draw(dt,opt);
}

function drawTopProv(){
  const sums = sumByProvince(); const arr=[];
  const key=detectPolyNameKey(); const nameByKey=new Map();
  (poly.features||[]).forEach(f=>{
    const label=String((f.properties||{})[key] ?? f.properties?.name ?? '').trim();
    nameByKey.set(normalizeProvKey(label), label);
  });
  sums.forEach((v,k)=> arr.push([nameByKey.get(k)||k, v]));
  arr.sort((a,b)=>b[1]-a[1]);
  const top = arr.slice(0,10);

  const dt = new google.visualization.DataTable();
  dt.addColumn('string','จังหวัด'); dt.addColumn('number','จำนวน');
  top.forEach(x=> dt.addRow(x));

  const opt = {
    backgroundColor:'transparent', legend:'none', bars:'horizontal',
    hAxis:{ format:'short', viewWindow:{min:0,max:GLOBAL_PROV_X_MAX} },
    chartArea:{left:120,right:16,top:10,bottom:30},
    colors:['#E31A1C']
  };
  new google.charts.Bar(document.getElementById('topProvChart')).draw(dt, google.charts.Bar.convertOptions(opt));
}

function drawCompare(){
  const year = (state.year==='__ALL__') ? ALL_YEARS[0] : +state.year;
  let cases=0, suspects=0;
  rows.forEach(r=>{
    if(+r[COL.year]!==year) return;
    if(groupOf(r[COL.offEn])==='คดี') cases += (+r[COL.val]||0);
    else suspects += (+r[COL.val]||0);
  });

  const dt = new google.visualization.DataTable();
  dt.addColumn('string','ประเภท'); dt.addColumn('number','จำนวน');
  dt.addRows([ ['คดี', cases], ['ผู้ต้องสงสัย', suspects] ]);

  const opt = {
    backgroundColor:'transparent', legend:'none',
    vAxis:{ format:'short', viewWindow:{min:0,max:GLOBAL_COMPARE_Y_MAX} },
    colors:['#b91c1c','#059669'],
    chartArea:{left:60,right:16,top:10,bottom:30}
  };
  new google.visualization.ColumnChart(document.getElementById('compareChart')).draw(dt,opt);
}
function redrawAll(){ drawMap(); drawTrend(); drawTopProv(); drawCompare(); }

/* ===== 8) Boot ===== */
async function boot(){
  try{
    const [polyJson, dataJson] = await Promise.all([ loadJSON(POLY_URL), loadJSON(DATA_URL) ]);
    poly = polyJson;
    rows = Array.isArray(dataJson) ? dataJson : (dataJson.features||[]).map(f=>f.properties||{});

    refreshYearOptions(); refreshOffenseOptions();
    precomputeFixedScales();

    initMap(); drawMap();
    google.charts.setOnLoadCallback(()=>{ drawTrend(); drawTopProv(); drawCompare(); });
  } finally {
    document.getElementById('loading')?.remove();
  }
}

/* ===== 9) Events ===== */
provBtn.addEventListener('click', searchProvince);
function searchProvince(){
  const q=norm(provSearch.value||''); if(!q||!geojsonLayer) return;
  let t=null;
  geojsonLayer.eachLayer(l=>{
    const p=l.feature?.properties||{};
    const names=[norm(p.name), norm(p.province_en||''), norm(p.province||'')];
    if(names.some(n=>n.includes(q))) t=l;
  });
  if(t){
    map.fitBounds(t.getBounds(), {padding:[8,8]});
    const orig={weight:t.options.weight, color:t.options.color, dashArray:t.options.dashArray};
    t.setStyle({weight:3,color:'var(--green)',dashArray:''}); setTimeout(()=>t.setStyle(orig),900);
  } else alert('ไม่พบจังหวัดที่ค้นหา');
}
provSearch.addEventListener('keydown', e=>{ if(e.key==='Enter') searchProvince(); });

yearSel.addEventListener('change', e=>{ state.year=e.target.value; refreshOffenseOptions(); redrawAll(); });
groupSel.addEventListener('change', e=>{ state.group=e.target.value; refreshOffenseOptions(); redrawAll(); });
offenseSel.addEventListener('change', e=>{ state.offense=e.target.value; redrawAll(); });
window.addEventListener('resize', ()=>{ if(map) map.invalidateSize(); redrawAll(); });

boot().catch(console.error);
</script>
</body>
</html>

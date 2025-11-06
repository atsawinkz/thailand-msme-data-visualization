<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แผนที่จำนวนธุรกิจ MSME ประเทศไทย</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    <style>
        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden;
            font-family: 'Prompt', sans-serif;
        }
        
        #mapid {
            height: 100vh;
            width: 100vw;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .header, .map-card {
            position: absolute;
            z-index: 1001;
        }
        
        .header {
            top: 0;
            left: 0;
            width: 100vw;
            background-color: #ffffff;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .map-card {
            top: 50px;
            left: 50px;
            max-width: 450px;
            width: 90vw;
            box-sizing: border-box;
            background: #eaf3fb54;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(74,108,247,0.08);
            padding: 32px 32px 24px 32px;
        }
        
        @media (max-width: 600px) {
            .map-card {
                top: 60px;
                left: 10px;
                max-width: 98vw;
                padding: 16px 8px 12px 8px;
            }
            .header {
                font-size: 18px;
                padding: 6px;
            }
            .logo img {
                height: 32px;
            }
        }
        
        .prompt-regular {
            font-family: "Prompt", sans-serif;
            font-weight: 400;
            font-style: normal;
        }
        
        .prompt-light {
            font-family: "Prompt", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .info { 
            padding: 6px 8px; 
            font: 14px/16px Arial, Helvetica, sans-serif; 
            background: white; 
            background: rgba(255,255,255,0.8); 
            box-shadow: 0 0 15px rgba(0,0,0,0.2); 
            border-radius: 5px; 
        } 

        .info h4 { 
            margin: 0 0 5px; 
            color: #777; 
        }

        .legend { 
            text-align: left; 
            line-height: 18px; 
            color: #555; 
        } 

        .legend i { 
            width: 18px; 
            height: 18px; 
            float: left; 
            margin-right:8px; 
            opacity: 0.7; 
        }

        .logo {
            padding: 0px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo img {
            height: 50px;
            margin-left: 10px;
        }
        
        /* From Uiverse.io by ErzenXz */ 
        .input {
            width: 100%;
            height: 15px;
            padding: 12px;
            border-radius: 12px;
            border: 1.5px solid lightgrey;
            outline: none;
            transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: 0px 0px 20px -18px;
        }

        .input:hover {
            border: 2px solid lightgrey;
            box-shadow: 0px 0px 20px -17px;
        }

        .input:active {
            transform: scale(0.95);
        }

        .input:focus {
            border: 2px solid grey;
        }

        .map-card-title {
            font-size: 2rem;
            font-weight: 700;
            color: #095d7e;
            margin-bottom: 18px;
            line-height: 1.2;
        }

        .map-card-desc {
            font-size: 1rem;
            color: #3a4a6b;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .info_container {
            position: absolute;
            top: 290px;
            left: 50px;
            z-index: 1000;
            border-radius: 18px;
            width: 420px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .msme_info {
            border-radius: 12px;
            padding: 12px;
            font-size: 1rem;
            color: #000000ff;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: flex-start;
            text-align: left;
            gap: 12px;
        }

        .msme_info img {
            padding-top: 15px;
        }
        
        .icon_box {
            flex: 0 0 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .info_box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 10px;
        }
        
        .msme_title {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 4px;
        }
        
        .msme_count {
            font-size: 25px;
            color: #000000ff;
            font-weight: 700;
        }

        .msmetotal {
            background: #4aa6ff;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
            grid-column: 1 / -1; /* ทำให้เต็มความกว้าง */
        }
        
        .micro {
            background: #87CEFA;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        
        .small {
            background: #87CEEB;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        
        .medium {
            background: #ccecee;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        
        .large {
            background: #f1f9ff;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        
        .text_info_container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        .container_maxmin {
            display: flex;
            flex-direction: row;
        }
        
        .mm-box {
            margin-top: 2px;
            border-top: 1px solid #111;
            padding-top: 5px;
            padding-right: 5px;
        }

        /* สไตล์สำหรับกราฟ */
        .chart-container {
            position: absolute;
            top: 50px;
            right: 20px;
            width: 550px;
            height: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            padding: 15px;
            box-sizing: border-box;
            overflow: hidden;
        }
        /* สไตล์สำหรับกราฟโดนัท */
        .chart-container-doughnut {
            position: absolute;
            top: 520px;
            right: 20px;
            width: 550px;
            height: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            padding: 15px;
            box-sizing: border-box;
            overflow: hidden;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #095d7e;
            margin-bottom: 15px;
            text-align: center;
        }

        #top10Chart {
            width: 100%;
            height: calc(100% - 40px);
        }

        @media (max-width: 1200px) {
            .chart-container {
                width: 500px;
                height: 400px;
            }
            .chart-container-doughnut {
                width: 500px;
                height: 400px;
            }
            .custom-map-legend {
                bottom: 470px;
                left: 15px;
                min-width: 160px;
                padding: 12px;
            }
        }

        @media (max-width: 768px) {
            .chart-container {
                position: relative;
                bottom: auto;
                right: auto;
                width: calc(100% - 40px);
                height: 350px;
                margin: 20px;
            }
            .chart-container-doughnut {
                position: relative;
                top: auto;
                right: auto;
                width: calc(100% - 40px);
                height: 350px;
                margin: 20px;
            }
            .custom-map-legend {
                position: relative;
                bottom: auto;
                left: auto;
                margin: 10px;
                width: calc(100% - 40px);
            }
        }

        .doughnut-chart {
            width: 600px;
            height: 400px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 15px;
            box-sizing: border-box;
        }

        .chart-title-doughnut {
            font-size: 18px;
            font-weight: 600;
            color: #095d7e;
            margin-bottom: 15px;
            text-align: center;
        }

        #sizeDistributionChart {
            width: 100%;
            height: calc(100% - 40px);
        }

        .custom-map-legend {
            position: absolute;
            bottom: 25px;
            left: 1070px;
            background: rgba(255, 255, 255, 0.95);
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: 1px solid #ddd;
            z-index: 1000;
            min-width: 180px;
            font-family: 'Prompt', sans-serif;
        }

        .legend-title {
            font-size: 14px;
            font-weight: 600;
            color: #095d7e;
            margin-bottom: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .legend-color {
            width: 18px;
            height: 18px;
            border-radius: 2px;
            margin-right: 10px;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .legend-label {
            font-size: 12px;
            color: #333;
        }

    </style>
</head>
<body>
    
    <div class="map-card">
        <a href="https://data.go.th/dataset/number-of-sme" target="_blank" class="map-card-title prompt-light" style="text-decoration: none; display: block;">จำนวนธุรกิจ MSME ปี 2567 <br>แบ่งตามขนาดธุรกิจ</a>
        <input placeholder="ค้นหาจังหวัด..." type="text" name="text" class="input" id="provinceSearch">        
    </div>

    <div class="info_container" id="infoContainer">
        <div class="msme_info msmetotal">
            <div class="icon_box">
                <!-- <img src="https://via.placeholder.com/50x50?text=T" alt="Total" style="height: 50px;"> -->
            </div>
            <div class="info_box">
                <div class="msme_title">ธุรกิจ MSME ทั้งหมดของจังหวัด <b id="provinceNameTitle">-</b></div>
                <div class="msme_count" id="msmetotalCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="msme_title">สูงสุด</div>
                        <div class="msme_count_mm" id="msmetotalMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="msme_title">ต่ำสุด</div>
                        <div class="msme_count_mm" id="msmetotalMin">-</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="msme_info micro">
            <div class="icon_box">
                <!-- <img src="https://via.placeholder.com/50x50?text=M" alt="Micro" style="height: 50px;"> -->
            </div>
            <div class="info_box">
                <div class="msme_title">ธุรกิจขนาดไมโคร</div>
                <div class="msme_count" id="microCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="msme_title">สูงสุด</div>
                        <div class="msme_count_mm" id="microMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="msme_title">ต่ำสุด</div>
                        <div class="msme_count_mm" id="microMin">-</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="msme_info small">
            <div class="icon_box">
                <!-- <img src="https://via.placeholder.com/50x50?text=S" alt="Small" style="height: 50px;"> -->
            </div>
            <div class="info_box">
                <div class="msme_title">ธุรกิจขนาดเล็ก</div>
                <div class="msme_count" id="smallCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="msme_title">สูงสุด</div>
                        <div class="msme_count_mm" id="smallMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="msme_title">ต่ำสุด</div>
                        <div class="msme_count_mm" id="smallMin">-</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="msme_info medium">
            <div class="icon_box">
                <!-- <img src="https://via.placeholder.com/50x50?text=M" alt="Medium" style="height: 50px;"> -->
            </div>
            <div class="info_box">
                <div class="msme_title">ธุรกิจขนาดกลาง</div>
                <div class="msme_count" id="mediumCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="msme_title">สูงสุด</div>
                        <div class="msme_count_mm" id="mediumMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="msme_title">ต่ำสุด</div>
                        <div class="msme_count_mm" id="mediumMin">-</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="msme_info large">
            <div class="icon_box">
                <!-- <img src="https://via.placeholder.com/50x50?text=L" alt="Large" style="height: 50px;"> -->
            </div>
            <div class="info_box">
                <div class="msme_title">ธุรกิจขนาดใหญ่</div>
                <div class="msme_count" id="largeCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="msme_title">สูงสุด</div>
                        <div class="msme_count_mm" id="largeMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="msme_title">ต่ำสุด</div>
                        <div class="msme_count_mm" id="largeMin">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container สำหรับกราฟ -->
    <div class="chart-container">
        <div class="chart-title">10 จังหวัดที่มีธุรกิจ MSME มากที่สุด</div>
        <div id="top10Chart"></div>
    </div>

    <!-- แผนภูมิโดนัท -->
    <div class="chart-container-doughnut doughnut-chart">
        <div class="chart-title-doughnut" id="doughnutTitle">สัดส่วนขนาดธุรกิจ MSME</div>
        <div id="sizeDistributionChart"></div>
    </div>

    <div id="mapid"></div>    
</body>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script>
        // ฟังก์ชันจัดรูปแบบตัวเลข
        function format(num) {
            if (typeof num !== 'number') return '-';
            return num.toLocaleString();
        }
        
        // โหลดข้อมูล GeoJSON
        var geojson_data;
        $.ajax({
            url: "./th_sme.json", 
            method: "GET",
            dataType: 'json',
            async: false,
            success : function(data){
                geojson_data = data;
            },
            error: function(xhr, status, error) {
                console.error("Error loading GeoJSON file: " + status + " - " + error);
                alert("ไม่สามารถโหลดไฟล์ GeoJSON ได้ กรุณาตรวจสอบชื่อไฟล์และที่อยู่ไฟล์");
            }
        });

        // คำนวณค่าสูงสุดและต่ำสุดสำหรับแต่ละประเภทธุรกิจ
        var maxMSMETotal = { value: -Infinity, province: '-' };
        var minMSMETotal = { value: Infinity, province: '-' };
        var maxMicro = { value: -Infinity, province: '-' };
        var minMicro = { value: Infinity, province: '-' };
        var maxSmall = { value: -Infinity, province: '-' };
        var minSmall = { value: Infinity, province: '-' };
        var maxMedium = { value: -Infinity, province: '-' };
        var minMedium = { value: Infinity, province: '-' };
        var maxLarge = { value: -Infinity, province: '-' };
        var minLarge = { value: Infinity, province: '-' };

        // เก็บข้อมูลจังหวัดทั้งหมดเพื่อใช้สร้างกราฟ
        var provincesData = [];

        // เพิ่มตัวแปรเก็บจังหวัดล่าสุด
        var lastSelectedProvince = null;

        geojson_data.features.forEach(function(f) {
            var p = f.properties;
            if (!p) return;
            
            // เพิ่มข้อมูลจังหวัดลงในอาร์เรย์สำหรับกราฟ
            provincesData.push({
                name: p.name,
                total: Number(p.MSME_TOTAL_2567),
            });
            
            // MSME Total
            if (Number(p.MSME_TOTAL_2567) > maxMSMETotal.value) {
                maxMSMETotal.value = Number(p.MSME_TOTAL_2567);
                maxMSMETotal.province = p.name;
            }
            if (Number(p.MSME_TOTAL_2567) < minMSMETotal.value) {
                minMSMETotal.value = Number(p.MSME_TOTAL_2567);
                minMSMETotal.province = p.name;
            }

            // Micro
            if (Number(p.MSME_MICRO_2567) > maxMicro.value) {
                maxMicro.value = Number(p.MSME_MICRO_2567);
                maxMicro.province = p.name;
            }
            if (Number(p.MSME_MICRO_2567) < minMicro.value) {
                minMicro.value = Number(p.MSME_MICRO_2567);
                minMicro.province = p.name;
            }
            
            // Small
            if (Number(p.MSME_S_2567) > maxSmall.value) {
                maxSmall.value = Number(p.MSME_S_2567);
                maxSmall.province = p.name;
            }
            if (Number(p.MSME_S_2567) < minSmall.value) {
                minSmall.value = Number(p.MSME_S_2567);
                minSmall.province = p.name;
            }
            
            // Medium
            if (Number(p.MSME_M_2567) > maxMedium.value) {
                maxMedium.value = Number(p.MSME_M_2567);
                maxMedium.province = p.name;
            }
            if (Number(p.MSME_M_2567) < minMedium.value) {
                minMedium.value = Number(p.MSME_M_2567);
                minMedium.province = p.name;
            }
            
            // Large
            if (Number(p.MSME_L_2567) > maxLarge.value) {
                maxLarge.value = Number(p.MSME_L_2567);
                maxLarge.province = p.name;
            }
            if (Number(p.MSME_L_2567) < minLarge.value) {
                minLarge.value = Number(p.MSME_L_2567);
                minLarge.province = p.name;
            }
        });

        // อัพเดทข้อมูลในกล่องข้อมูล
        function updateMSMEInfo(props) {
            var provinceName = props ? props.name : 'กรุณาคลิกที่จังหวัด';
            document.getElementById('provinceNameTitle').textContent = provinceName;
            document.getElementById('msmetotalCount').textContent =
                props ? format(Number(props.MSME_TOTAL_2567)) + ' ราย' : '-';
            document.getElementById('microCount').textContent =
                props ? format(Number(props.MSME_MICRO_2567)) + ' ราย' : '-';
            document.getElementById('smallCount').textContent =
                props ? format(Number(props.MSME_S_2567)) + ' ราย' : '-';
            document.getElementById('mediumCount').textContent =
                props ? format(Number(props.MSME_M_2567)) + ' ราย' : '-';
            document.getElementById('largeCount').textContent =
                props ? format(Number(props.MSME_L_2567)) + ' ราย' : '-';

            document.getElementById('msmetotalMax').textContent =
                format(maxMSMETotal.value) + ' ราย (' + maxMSMETotal.province + ')';
            document.getElementById('msmetotalMin').textContent =
                format(minMSMETotal.value) + ' ราย (' + minMSMETotal.province + ')';

            document.getElementById('microMax').textContent =
                format(maxMicro.value) + ' ราย (' + maxMicro.province + ')';
            document.getElementById('microMin').textContent =
                format(minMicro.value) + ' ราย (' + minMicro.province + ')';

            document.getElementById('smallMax').textContent =
                format(maxSmall.value) + ' ราย (' + maxSmall.province + ')';
            document.getElementById('smallMin').textContent =
                format(minSmall.value) + ' ราย (' + minSmall.province + ')';

            document.getElementById('mediumMax').textContent =
                format(maxMedium.value) + ' ราย (' + maxMedium.province + ')';
            document.getElementById('mediumMin').textContent =
                format(minMedium.value) + ' ราย (' + minMedium.province + ')';

            document.getElementById('largeMax').textContent =
                format(maxLarge.value) + ' ราย (' + maxLarge.province + ')';
            document.getElementById('largeMin').textContent =
                format(minLarge.value) + ' ราย (' + minLarge.province + ')';
        }

        // สร้างแผนที่
        var map = L.map('mapid').setView([13, 101.5], 5);

        // เพิ่มแผนที่พื้นหลัง
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://carto.com/">CartoDB</a>'
        }).addTo(map);

        // กำหนดสีตามจำนวนธุรกิจทั้งหมด
        function getColor(d) {
            return  d > 150000 ? '#08306b' :
                    d > 90000 ? '#08519c' :
                    d > 60000 ? '#2171b5' :
                    d > 30000 ? '#4292c6' :
                    d > 15000 ? '#6baed6' :
                    d > 8000 ? '#9ecae1' :
                    d > 5000 ? '#c6dbef' :
                    '#eff3ff';
        }

        // กำหนดสไตล์ให้กับแต่ละจังหวัด
        function style(feature) {
            return {
                fillColor: getColor(feature.properties.MSME_TOTAL_2567),
                weight: 1,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        // ฟังก์ชันเมื่อโฮเวอร์เหนือจังหวัด
        function highlightFeature(e) {
            var layer = e.target;
            layer.setStyle({
                weight: 2,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });
            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
            
            // บันทึกจังหวัดล่าสุด
            lastSelectedProvince = layer.feature.properties;
            
            updateMSMEInfo(lastSelectedProvince);
            drawSizeDistributionDoughnutChart(lastSelectedProvince);
        }

        // ฟังก์ชันเมื่อออกจากจังหวัด
        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            
            // ยังคงแสดงข้อมูลจังหวัดล่าสุด ไม่กลับไปแสดงข้อมูลทั้งประเทศ
            if (lastSelectedProvince) {
                updateMSMEInfo(lastSelectedProvince);
                drawSizeDistributionDoughnutChart(lastSelectedProvince);
            } else {
                // ถ้ายังไม่เคยเลือกจังหวัดไหน ให้แสดงข้อมูลทั้งประเทศ
                updateMSMEInfo(null);
                drawSizeDistributionDoughnutChart();
            }
        }

        // ฟังก์ชันเมื่อคลิกจังหวัด
        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
            
            // บันทึกจังหวัดล่าสุดเมื่อคลิก
            lastSelectedProvince = e.target.feature.properties;
        }

        // เพิ่มฟังก์ชันให้กับแต่ละจังหวัด
        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

        // เพิ่ม GeoJSON ลงในแผนที่
        var geojson = L.geoJson(geojson_data, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);
        
        // อัพเดทข้อมูลเริ่มต้น
        updateMSMEInfo(null);

        // ฟังก์ชันค้นหาและซูมไปยังจังหวัด
        document.getElementById('provinceSearch').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                var searchText = this.value.trim();
                if (!searchText) return;
                
                var found = false;
                geojson.eachLayer(function(layer) {
                    var props = layer.feature.properties;
                    // ค้นหาจากชื่อจังหวัด
                    if (props && props.name && props.name.indexOf(searchText) !== -1) {
                        map.flyToBounds(layer.getBounds(), {duration: 1.5});
                        layer.fire('mouseover');
                        
                        // บันทึกจังหวัดล่าสุด
                        lastSelectedProvince = props;
                        
                        updateMSMEInfo(lastSelectedProvince);
                        drawSizeDistributionDoughnutChart(lastSelectedProvince);
                        found = true;
                    }
                });
                
                if (!found) {
                    alert('ไม่พบจังหวัด "' + this.value + '"');
                }
            }
        });

        // ฟังก์ชันสร้างกราฟ Top 10 จังหวัด
        function drawTop10Chart() {
            // เรียงลำดับจังหวัดตามจำนวนธุรกิจทั้งหมดจากมากไปน้อย
            var sortedProvinces = provincesData.sort(function(a, b) {
                return b.total - a.total;
            });
            
            // เลือกมาเฉพาะ 10 อันดับแรก
            var top10 = sortedProvinces.slice(0, 10);
            
            // สร้างข้อมูลสำหรับกราฟ
            var chartData = [['จังหวัด', 'จำนวนธุรกิจ', { role: 'annotation' }, { role: 'style' }]];
            
            top10.forEach(function(province) {
                var color = getColor(province.total);
                chartData.push([
                    province.name, 
                    province.total, 
                    province.total.toLocaleString() + ' ราย',
                    'color: ' + color
                ]);
            });
            
            // สร้างกราฟ
            var data = google.visualization.arrayToDataTable(chartData);
            
            var options = {
                title: '',
                chartArea: { 
                    width: '65%',
                    height: '80%',
                    left: 130,
                    top: 30,
                    bottom: 30
                },
                hAxis: { 
                    title: 'จำนวนธุรกิจ',
                    minValue: 0,
                    format: 'short'
                },
                vAxis: { 
                    title: '',
                    textStyle: {
                        fontSize: 12
                    }
                },
                bar: { 
                    groupWidth: '70%' 
                },
                // colors: ['#1694c6'],
                legend: { position: 'none' }
            };

            var chart = new google.visualization.BarChart(document.getElementById('top10Chart'));
            chart.draw(data, options);
        }

        // ฟังก์ชันสร้างแผนภูมิโดนัทแสดงสัดส่วนขนาดธุรกิจ
        function drawSizeDistributionDoughnutChart(provinceData = null) {
            var data, title, totalMSME;
            
            // ใช้จังหวัดล่าสุดถ้ามีการส่งค่าเข้ามา
            var displayData = provinceData || lastSelectedProvince;
            
            if (displayData) {
                // แสดงข้อมูลจังหวัดที่เลือก
                data = [
                    ['ขนาดไมโคร', Number(displayData.MSME_MICRO_2567)],
                    ['ขนาดเล็ก', Number(displayData.MSME_S_2567)],
                    ['ขนาดกลาง', Number(displayData.MSME_M_2567)],
                    ['ขนาดใหญ่', Number(displayData.MSME_L_2567)]
                ];
                totalMSME = Number(displayData.MSME_TOTAL_2567);
                title = `สัดส่วนขนาดธุรกิจ: ${displayData.name}`;
            } else {
                // แสดงข้อมูลรวมทั้งประเทศ
                var totalMicro = geojson_data.features.reduce((sum, f) => sum + Number(f.properties.MSME_MICRO_2567), 0);
                var totalSmall = geojson_data.features.reduce((sum, f) => sum + Number(f.properties.MSME_S_2567), 0);
                var totalMedium = geojson_data.features.reduce((sum, f) => sum + Number(f.properties.MSME_M_2567), 0);
                var totalLarge = geojson_data.features.reduce((sum, f) => sum + Number(f.properties.MSME_L_2567), 0);
                
                data = [
                    ['ขนาดไมโคร', totalMicro],
                    ['ขนาดเล็ก', totalSmall],
                    ['ขนาดกลาง', totalMedium],
                    ['ขนาดใหญ่', totalLarge]
                ];
                totalMSME = totalMicro + totalSmall + totalMedium + totalLarge;
                title = 'สัดส่วนขนาดธุรกิจ MSME ทั้งประเทศ';
            }
            
            document.getElementById('doughnutTitle').textContent = title;
            
            // สร้าง DataTable พิเศษที่รวมทั้งค่าและ label ที่ต้องการ
            var chartData = new google.visualization.DataTable();
            chartData.addColumn('string', 'ขนาด');
            chartData.addColumn('number', 'จำนวน');
            chartData.addColumn({type: 'string', role: 'tooltip'});
            
            // กำหนดสีสำหรับแต่ละ slice ตามจำนวนธุรกิจ
            var slicesConfig = {};
            
            // เพิ่มข้อมูลพร้อม tooltip ที่แสดงจำนวน
            data.forEach(function(row, index) {
                var percentage = ((row[1] / totalMSME) * 100).toFixed(1);
                var tooltipText = row[0] + ': ' + format(row[1]) + ' ราย (' + percentage + '%)';
                chartData.addRow([row[0], row[1], tooltipText]);
                
                // กำหนดสีตามจำนวนธุรกิจของแต่ละขนาด
                slicesConfig[index] = { color: getColor(row[1]) };
            });
            
            var options = {
                title: '',
                pieHole: 0.4,
                pieSliceText: 'percentage',
                pieSliceTextStyle: {
                    color: 'white',
                    fontName: 'Prompt',
                    fontSize: 14,
                    bold: true
                },
                slices: slicesConfig,
                legend: {
                    position: 'labeled',
                    textStyle: {
                        fontSize: 12,
                        fontName: 'Prompt'
                    },
                    labeledValueText: 'value'
                },
                tooltip: {
                    text: 'value',
                    showColorCode: true,
                    textStyle: {
                        fontName: 'Prompt',
                        fontSize: 12
                    }
                },
                chartArea: {
                    left: 10,
                    top: 10,
                    width: '95%',
                    height: '85%'
                }
            };
            
            var chart = new google.visualization.PieChart(document.getElementById('sizeDistributionChart'));
            chart.draw(chartData, options);
        }

        // สร้าง Custom Legend 
        function createCustomLegend() {
            var legendDiv = document.createElement('div');
            legendDiv.className = 'custom-map-legend';
            
            var grades = [0, 5000, 8000, 15000, 30000, 60000, 90000, 150000];
            var labels = [];
            
            for (var i = 0; i < grades.length; i++) {
                var from = grades[i];
                var to = grades[i + 1];
                
                labels.push(
                    '<div class="legend-item">' +
                    '<span class="legend-color" style="background:' + getColor(from + 1) + '"></span>' +
                    '<span class="legend-label">' + from.toLocaleString() + (to ? '&ndash;' + to.toLocaleString() : '+') + '</span>' +
                    '</div>'
                );
            }
            
            legendDiv.innerHTML = 
                '<div class="legend-title">จำนวนธุรกิจ MSME</div>' +
                labels.join('');
            
            document.body.appendChild(legendDiv);
        }

        // เรียกใช้ฟังก์ชันสร้าง Custom Legend
        createCustomLegend();

        // โหลด Google Charts และสร้างกราฟ
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(function() {
            drawTop10Chart();
            drawSizeDistributionDoughnutChart();
        });
    </script>
</html>
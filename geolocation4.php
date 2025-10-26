
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geolocation</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    
    <style>
        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: hidden; /* ป้องกัน scroll bar เกินขอบ */
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
        }
        
        .map-card {
            top: 100px;
            left: 40px;
            max-width: 420px;
            width: 90vw;
            box-sizing: border-box;
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
        body {
            margin: 0;
            padding: 0;
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


        #mapid {
            height: 100vh;
            width: 100vw;
            max-width: 100%;
            max-height: 100%;
        }

        .info { 
        padding: 6px 8px; 
        font: 14px/16px Arial, Helvetica, sans-serif; 
        background: white; 
        background: rgba(255,255,255,0.8); 
        box-shadow: 0 0 15px rgba(0,0,0,0.2); 
        border-radius: 5px; 
        } 

        .info h4 { margin: 0 0 5px; color: #777; }

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

        .header {
            background-color: #ffffff;
            padding: 10px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 0px;
        }
        .logo {
            padding: 0px;
            display: flex;
            justify-content:space-between;
            align-items: center;
        }
        .logo img {
            height: 50px;
            margin-left: 10px;
            
            
        }
        /* From Uiverse.io by ErzenXz */ 
        .input {
        width: 100%;
        max-width: 220px;
        height: 15px;
        padding: 12px;
        border-radius: 12px;
        border: 1.5px solid lightgrey;
        outline: none;
        transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
        box-shadow: 0px 0px 20px -18px;
        margin-right: 10px;
        
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

        /* ...existing code... */
        .map-card {
            position: absolute;
            top: 80px;
            left: 40px;
            z-index: 1000;
            background: #eaf3fb54;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(74,108,247,0.08);
            padding: 32px 32px 24px 32px;
            max-width: 420px;
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

        .map-card-btn {
            padding: 0.8rem 2.2rem;
            border: none;
            border-radius: 2rem;
            background: #fff;
            color: #2563eb;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(74,108,247,0.08);
            transition: background 0.2s, color 0.2s;
        }

        .map-card-btn:hover {
            background: #2563eb;
            color: #fff;
        }
       
        .info_container {
            position: absolute;
            top: 350px;
            left: 40px;
            z-index: 1000;
            border-radius: 18px;
            width: 420px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
                /* ...existing code... */
        .staff_info {
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

        .staff_info img {
            padding-top : 15px;
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
        .staff_info {

        }
        .staff_title {
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 4px;
        }
        
        .staff_count {
            font-size: 25px;
            color: #000000ff;
            font-weight: 700;
        }
        /* ...existing code... */

        .doctor {
            background: #19b79aff;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        .dentist {
            background: #1694c6ff;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        .med {
            background: #ccecee;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 1px 2px 0px;
        }
        .nurse {
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
            flex-direction : row;
            
        }
        .mm-box{
            margin-top:2px;
            border-top : 1px solid #111;
            padding-top : 5px;
            padding-right: 5px;
            


        }
        /* From Uiverse.io by ErzenXz */ 
        button {
        width: fit-content;
        min-width: 100px;
        height: 45px;
        padding: 8px;
        border-radius: 5px;
        border: 2.5px solid #E0E1E4;
        box-shadow: 0px 0px 20px -20px;
        cursor: pointer;
        background-color: white;
        transition: all 0.2s ease-in-out 0ms;
        user-select: none;
        font-family: 'Poppins', sans-serif;
        }

        button:hover {
        background-color: #F2F2F2;
        box-shadow: 0px 0px 20px -18px;
        }

        button:active {
        transform: scale(0.95);
        }

        

    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="https://moph.gdcatalog.go.th/dataset/health_workforce_ratio/resource/27b9643f-6507-4d16-83f2-83ba03f883e5" target="_blank">
                <img src="logo.png" alt="Logo" />
            </a>
                
        </div>
    </div>
        <!-- ...existing code... -->
    <div class="map-card ">
        <div class="map-card-title prompt-light ">สัดส่วนบุคลากรทางการแพทย์ ปี 2567 <br>ต่อประชากร 1,000 คน</div>
        <input placeholder="ค้นหาจังหวัด..." type="text" name="text" class="input">        
        
    </div>

        <!-- ...existing code... -->
        <!-- ...existing code... -->
    <div class="info_container" id="infoContainer">
        <div class="staff_info doctor">
            <div class="icon_box">
                <img src="doctor.png" alt="doctor" style="height: 50px;">
            </div>
            <div class="info_box">
                <div class="staff_title">นายแพทย์</div>
                <div class="staff_count" id="doctorCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="staff_title">สูงสุด</div>
                        <div class="staff_count_mm" id="doctorMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="staff_title">ต่ำสุด</div>
                        <div class="staff_count_mm" id="doctorMin">-</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="staff_info dentist">
            <div class="icon_box">
                <img src="tooth.png" alt="dentist" style="height: 50px;">
            </div>
            <div class="info_box">
                <div class="staff_title">ทันตแพทย์</div>
                <div class="staff_count" id="dentistCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="staff_title">สูงสุด</div>
                        <div class="staff_count_mm" id="dentistMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="staff_title">ต่ำสุด</div>
                        <div class="staff_count_mm" id="dentistMin">-</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="staff_info med">
            <div class="icon_box">
                <img src="med.png" alt="med" style="height: 50px;">
            </div>
            <div class="info_box">
                <div class="staff_title">เภสัชกร</div>
                <div class="staff_count" id="medCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="staff_title">สูงสุด</div>
                        <div class="staff_count_mm" id="medMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="staff_title">ต่ำสุด</div>
                        <div class="staff_count_mm" id="medMin">-</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="staff_info nurse">
            <div class="icon_box">
                <img src="nurse.png" alt="nurse" style="height: 50px;">
            </div>
            <div class="info_box">
                <div class="staff_title">พยาบาลวิชาชีพ</div>
                <div class="staff_count" id="nurseCount">-</div>
                <div class="container_maxmin">
                    <div class="mm-box">
                        <div class="staff_title">สูงสุด</div>
                        <div class="staff_count_mm" id="nurseMax">-</div>
                    </div>
                    <div class="mm-box">
                        <div class="staff_title">ต่ำสุด</div>
                        <div class="staff_count_mm" id="nurseMin">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ...existing code... -->


    <div id="mapid"></div>    
</body>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script>


                
        function format(num, decimals) {
            if (typeof num !== 'number') return '-';
            return num.toFixed(decimals);
        }
                // ...existing code...
        

        var geojson_data;
        $.ajax({
        url: "./df_THdocter.json",
        dataType: "json",
        method: "GET",
        async: false,
        success : function(data){
            geojson_data = data;
        }
        });


        // คำนวณค่าสูงสุดและต่ำสุด
        var maxDoctor = { value: -Infinity, province: '-' };
        var minDoctor = { value: Infinity, province: '-' };
        var maxDentist = { value: -Infinity, province: '-' };
        var minDentist = { value: Infinity, province: '-' };
        var maxMed = { value: -Infinity, province: '-' };
        var minMed = { value: Infinity, province: '-' };
        var maxNurse = { value: -Infinity, province: '-' };
        var minNurse = { value: Infinity, province: '-' };

        geojson_data.features.forEach(function(f) {
            var p = f.properties;
            if (!p) return;
            // Doctor
            if (Number(p.p) > maxDoctor.value) {
                maxDoctor.value = Number(p.p);
                maxDoctor.province = p.name_th;
            }
            if (Number(p.p) < minDoctor.value) {
                minDoctor.value = Number(p.p);
                minDoctor.province = p.name_th;
            }
            // Dentist
            if (Number(p.p_teet) > maxDentist.value) {
                maxDentist.value = Number(p.p_teet);
                maxDentist.province = p.name_th;
            }
            if (Number(p.p_teet) < minDentist.value) {
                minDentist.value = Number(p.p_teet);
                minDentist.province = p.name_th;
            }
            // Med
            if (Number(p.p_med) > maxMed.value) {
                maxMed.value = Number(p.p_med);
                maxMed.province = p.name_th;
            }
            if (Number(p.p_med) < minMed.value) {
                minMed.value = Number(p.p_med);
                minMed.province = p.name_th;
            }
            // Nurse
            if (Number(p.p_nurse) > maxNurse.value) {
                maxNurse.value = Number(p.p_nurse);
                maxNurse.province = p.name_th;
            }
            if (Number(p.p_nurse) < minNurse.value) {
                minNurse.value = Number(p.p_nurse);
                minNurse.province = p.name_th;
            }
        });



        function updateStaffInfo(props) {
            document.getElementById('doctorCount').textContent =
                props ? format(Number(props.p) * 10, 0) + ' คน' : '-';
            document.getElementById('dentistCount').textContent =
                props ? format(Number(props.p_teet) * 10, 0) + ' คน' : '-';
            document.getElementById('medCount').textContent =
                props ? format(Number(props.p_med) * 10, 0) + ' คน' : '-';
            document.getElementById('nurseCount').textContent =
                props ? format(Number(props.p_nurse) * 10, 0) + ' คน' : '-';

            document.getElementById('doctorMax').textContent =
                format(maxDoctor.value * 10, 0) + ' คน (' + maxDoctor.province + ')';
            document.getElementById('doctorMin').textContent =
                format(minDoctor.value * 10, 0) + ' คน (' + minDoctor.province + ')';

            document.getElementById('dentistMax').textContent =
                format(maxDentist.value * 10, 0) + ' คน (' + maxDentist.province + ')';
            document.getElementById('dentistMin').textContent =
                format(minDentist.value * 10, 0) + ' คน (' + minDentist.province + ')';

            document.getElementById('medMax').textContent =
                format(maxMed.value * 10, 0) + ' คน (' + maxMed.province + ')';
            document.getElementById('medMin').textContent =
                format(minMed.value * 10, 0) + ' คน (' + minMed.province + ')';

            document.getElementById('nurseMax').textContent =
                format(maxNurse.value * 10, 0) + ' คน (' + maxNurse.province + ')';
            document.getElementById('nurseMin').textContent =
                format(minNurse.value * 10, 0) + ' คน (' + minNurse.province + ')';
        }

        var map = L.map('mapid').setView([13, 101.5], 5);

        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://carto.com/">CartoDB</a>'
        }).addTo(map);
        

        // control that shows state info on hover
        /*var info = L.control();

        info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
        };

        info.update = function (props) {
        this._div.innerHTML = '<h4>สัดส่วนแพทย์ในประเทศไทย</h4>' +  
            (props ? '<b>' + props.name_th + '</b><br />' + 'นายแพทย์ '+ format(props.p*10,0) + ' คน / ประชากร 1,000 คน ' 
            +'<br />' + 'ทันตแพทย์ '+ format(props.p_teet*10,0) + ' คน / ประชากร 1,000 คน '
            +'<br />' + 'เภสัชกร '+ format(props.p_med*10,0) + ' คน / ประชากร 1,000 คน '
            +'<br />' + 'พยาบาลวิชาชีพ '+ format(props.p_nurse*10,0) + ' คน / ประชากร 1,000 คน '
            : 'วางเมาส์เหนือจังหวัด');
        };

        info.addTo(map);*/

        function getColor(d) {
            return d > 234  ? '#d8f1f3' :
                d > 150  ? '#89d6dc' :
                d > 100  ? '#42d3ddff' :
                d > 50   ? '#2ca4acff' :
                d > 15   ? '#094b4fff' : 
                d > 0    ? '#ff5959ff' :
                            '#62615fff';
        }

        function style(feature) {
            return {
                fillColor: getColor(feature.properties.p*10), // <<-- fix ใช้ค่า p อย่างเดียว
                weight: 1,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }


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
            /*
            info.update(layer.feature.properties);
            updateStaffInfo(layer.feature.properties); // เพิ่มบรรทัดนี้*/
            updateStaffInfo(layer.feature.properties)
        }

        var geojson;

        function resetHighlight(e) {
        geojson.resetStyle(e.target);
        /*info.update();*/
        }

        function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: zoomToFeature
        });
        }

        geojson = L.geoJson(geojson_data, {
        style: style,
        onEachFeature: onEachFeature
        }).addTo(map);

        var legend = L.control({position: 'bottomright'});

        legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
            grades = [0, 10, 20, 50, 100, 200, 500, 1000],
            labels = [],
            from, to;
        for (var i = 0; i < grades.length; i++) {
            from = grades[i];
            to = grades[i + 1];
            labels.push(
            '<i style="background:' + getColor(from + 1) + '"></i> ' +
            from + (to ? '&ndash;' + to : '+'));
        }
        div.innerHTML = labels.join('<br>');
        return div;
        };

        legend.addTo(map);
        updateStaffInfo(null)

    </script>
    <script>
  
        // ฟังก์ชันค้นหาและ zoom ไปยังจังหวัด
        document.querySelector('.input').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                var searchText = this.value.trim();
                if (!searchText) return;
                var found = false;
                geojson.eachLayer(function(layer) {
                    var props = layer.feature.properties;
                    // ค้นหาจาก name_th (ชื่อจังหวัดภาษาไทย)
                    if (props && props.name_th && props.name_th.indexOf(searchText) !== -1) {
                        map.flyToBounds(layer.getBounds(), {duration: 1.5}); // ใช้ flyToBounds เพื่อซูมช้าๆ
                        layer.fire('mouseover');
                        updateStaffInfo(props);
                        found = true;
                    }
                });
                if (!found) {
                    alert('ไม่พบจังหวัดที่ค้นหา');
                }
            }
        });
    </script>


</html>
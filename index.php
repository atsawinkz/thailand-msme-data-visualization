<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thai MSME Choropleth Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #mapid {
            height: 100vh;
            width: 100vw;
            position: absolute;
            top: 0;
            left: 0;
        }

        .info { 
        padding: 6px 8px; 
        font: 14px/16px Arial, Helvetica, sans-serif; 
        background: white; 
        background: rgba(255,255,255,0.9);
        box-shadow: 0 0 15px rgba(0,0,0,0.2); 
        border-radius: 5px; 
        } 

        .info h4 { margin: 0 0 5px; color: #333; } 
        .info b { color: #0066cc; } 

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
        
        /* สไตล์สำหรับช่องค้นหา */
        .search-box {
            position: absolute;
            top: 20px; /* ตำแหน่งด้านบน */
            left: 50%; /* จัดกึ่งกลาง */
            transform: translateX(-50%);
            z-index: 1000;
            width: 300px; /* ปรับขนาดตามต้องการ */
        }
        .search-input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #0066cc;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            font-size: 16px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s;
        }
        .search-input:focus {
            border-color: #004080;
        }
    </style>
</head>
<body>
    <div class="search-box">
        <input type="text" id="provinceSearch" class="search-input" placeholder="ค้นหาจังหวัด...">
    </div>

    <div id="mapid"></div> 
</body>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script>
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

        var map = L.map('mapid').setView([13, 101.5], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
        }).addTo(map);

        var info = L.control();

        info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
        };

        info.update = function (props) {
            this._div.innerHTML = '<h4>จำนวน MSME ปี 2567 (ราย)</h4>' + 
                (props ? 
                '<b>' + props.name + '</b><br />' + 
                'รวมทั้งหมด: <b>' + (props.MSME_TOTAL_2567 ? props.MSME_TOTAL_2567.toLocaleString() : 'N/A') + '</b><hr style="margin: 5px 0;">' +
                'Micro: ' + (props.MSME_MICRO_2567 ? props.MSME_MICRO_2567.toLocaleString() : '0') + '<br>' +
                'Small: ' + (props.MSME_S_2567 ? props.MSME_S_2567.toLocaleString() : '0') + '<br>' +
                'Medium: ' + (props.MSME_M_2567 ? props.MSME_M_2567.toLocaleString() : '0') + '<br>' +
                'Large: ' + (props.MSME_L_2567 ? props.MSME_L_2567.toLocaleString() : '0')
                : 'ชี้ที่จังหวัดเพื่อดูข้อมูล');
        };

        info.addTo(map);

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

        function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });
        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }
        info.update(layer.feature.properties);
        }

        var geojson;

        function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
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
            grades = [0, 5000, 8000, 15000, 30000, 60000, 90000, 150000],
            labels = [],
            from, to;

        for (var i = 0; i < grades.length; i++) {
            from = grades[i];
            to = grades[i + 1];

            labels.push(
            '<i style="background:' + getColor(from + 1) + '"></i> ' +
            from.toLocaleString() + (to ? '&ndash;' + to.toLocaleString() : '+'));
        }

        div.innerHTML = labels.join('<br>');
        return div;
        };

        legend.addTo(map);
        
        // ## ฟังก์ชันค้นหาจังหวัด
        document.getElementById('provinceSearch').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                var searchText = this.value.trim().toLowerCase();
                if (!searchText) return;
                
                var foundLayer = null;

                geojson.eachLayer(function(layer) {
                    var props = layer.feature.properties;
                    // ค้นหาโดยไม่สนใจขนาดตัวอักษร
                    if (props && props.name && props.name.toLowerCase().indexOf(searchText) !== -1) {
                        foundLayer = layer;
                        return; // หยุดการวนลูปเมื่อเจอ
                    }
                });

                if (foundLayer) {
                    map.flyToBounds(foundLayer.getBounds(), {duration: 1.0, padding: [100, 100]}); // ซูมไปยังจังหวัดที่พบ
                    foundLayer.fire('mouseover'); // แสดงข้อมูลจังหวัด
                } else {
                    alert('ไม่พบจังหวัด "' + this.value + '"');
                }
            }
        });

    </script>
</html>
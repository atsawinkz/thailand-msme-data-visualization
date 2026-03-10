# 🗺️ แผนที่จำนวนธุรกิจ MSME ประเทศไทย ปี 2567

Dashboard เชิงโต้ตอบสำหรับแสดงสัดส่วนธุรกิจ MSME (Micro, Small, Medium, Large) ในแต่ละจังหวัดทั่วประเทศไทย ประจำปี พ.ศ. 2567

🌐 **[ดู Live Demo บน GitHub Pages](https://your-username.github.io/your-repo-name)**

---

## 📸 ตัวอย่างหน้าจอ

![MSME Map Dashboard](./preview.png)

---

## ✨ ฟีเจอร์หลัก

- **แผนที่ Choropleth** แบบโต้ตอบ แสดงความหนาแน่นของธุรกิจ MSME แต่ละจังหวัด
- **Hover & Click** เพื่อดูรายละเอียดข้อมูลแต่ละจังหวัด
- **ค้นหาจังหวัด** — พิมพ์ชื่อจังหวัดแล้วกด Enter เพื่อซูมไปยังจังหวัดนั้น
- **กราฟ Top 10** จังหวัดที่มีธุรกิจ MSME มากที่สุด
- **กราฟโดนัท** แสดงสัดส่วนขนาดธุรกิจของจังหวัดที่เลือก
- **สถิติ Max/Min** แสดงจังหวัดที่มีธุรกิจมากที่สุดและน้อยที่สุดในแต่ละประเภท

---

## 🛠️ เทคโนโลยีที่ใช้

| เทคโนโลยี | รายละเอียด |
|---|---|
| HTML / CSS / JavaScript | โครงสร้างและตรรกะหลัก |
| [Leaflet.js](https://leafletjs.com/) v1.9.4 | แสดงผลแผนที่แบบ Interactive |
| [Google Charts](https://developers.google.com/chart) | กราฟแท่งและกราฟโดนัท |
| [jQuery](https://jquery.com/) v3.7.1 | โหลดข้อมูล GeoJSON ผ่าน AJAX |
| [Google Fonts – Prompt](https://fonts.google.com/specimen/Prompt) | ฟอนต์ภาษาไทย |
| [CartoDB Basemap](https://carto.com/basemaps/) | แผนที่พื้นหลัง |

---

## 📂 โครงสร้างไฟล์

```
thmap/
├── index.html      # ไฟล์หลัก (HTML + CSS + JavaScript)
└── th_sme.json     # ข้อมูล GeoJSON รายจังหวัด (ขอบเขตแผนที่ + ข้อมูล MSME)
```

---

## 🚀 วิธีรันในเครื่อง

เปิดไฟล์ `index.html` ผ่าน Web Server (เนื่องจากการโหลด GeoJSON ใช้ AJAX)

```bash
# ตัวอย่างด้วย Python
python -m http.server 8000
# จากนั้นเปิด http://localhost:8000
```

หรือใช้ XAMPP / Live Server Extension บน VS Code

---

## 📊 แหล่งที่มาของข้อมูล

ข้อมูลจำนวนธุรกิจ MSME ปี พ.ศ. 2567 จาก **สำนักงานส่งเสริมวิสาหกิจขนาดกลางและขนาดย่อม (สสว.)**

🔗 [data.go.th – จำนวนธุรกิจ SME จำแนกตามขนาด](https://data.go.th/dataset/number-of-sme)

---

## 📄 License

MIT License — ใช้งานได้อย่างอิสระ

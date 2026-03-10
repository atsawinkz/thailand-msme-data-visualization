# Thailand MSME Business Map 2024

An interactive dashboard displaying the distribution of MSME (Micro, Small, Medium, Large) businesses across all provinces in Thailand for the year 2024.

---

## Key Features

- **Interactive Choropleth Map** showing MSME business density by province
- **Hover & Click** to view detailed information for each province
- **Province Search** — type a province name and press Enter to zoom to that province
- **Top 10 Chart** of provinces with the highest number of MSME businesses
- **Donut Chart** showing the business size breakdown for the selected province
- **Max/Min Statistics** displaying the provinces with the most and fewest businesses per category

---

## Technologies Used

| Technology | Details |
|---|---|
| HTML / CSS / JavaScript | Core structure and logic |
| [Leaflet.js](https://leafletjs.com/) v1.9.4 | Interactive map rendering |
| [Google Charts](https://developers.google.com/chart) | Bar charts and donut charts |
| [jQuery](https://jquery.com/) v3.7.1 | Loading GeoJSON data via AJAX |
| [Google Fonts – Prompt](https://fonts.google.com/specimen/Prompt) | Thai language font |
| [CartoDB Basemap](https://carto.com/basemaps/) | Base map tiles |

---

## File Structure

```
thmap/
├── index.html      # Main file (HTML + CSS + JavaScript)
└── th_sme.json     # GeoJSON data by province (map boundaries + MSME data)
```

---

## Running Locally

Open `index.html` through a Web Server (required because GeoJSON loading uses AJAX).

```bash
# Example with Python
python -m http.server 8000
# Then open http://localhost:8000
```

Or use XAMPP / Live Server Extension on VS Code.

---

## Data Source

MSME business count data for 2024 from the **Office of Small and Medium Enterprises Promotion (OSMEP)**.

[data.go.th – Number of SME businesses by size](https://data.go.th/dataset/number-of-sme)

---

## License

MIT License — Free to use

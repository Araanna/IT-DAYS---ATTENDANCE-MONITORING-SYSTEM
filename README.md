# 📋 IT Days — Attendance Monitoring System

> An attendance tracking system built for the IT Days event. Features QR code generation, real-time scanning, and role-based access for attendees and student body officers (SBOs). Built with Laravel API backend and Vue.js frontend SPA using modern web technologies.

---

## ✨ **Features**

<div align="left">

🔐 **Authentication** — Registration & Login for attendees and SBOs  
📊 **Dashboard** — View user info and attendance data  
📸 **QR System** — QR Code generation and scanning for attendance  
👥 **Role Management** — SBO role with scanning privileges and admin view  
📤 **Data Export** — Export attendance to Google Sheets *(coming soon)*  
📚 **Course Management** — Year Level & Course management via dropdowns  

</div>

---

## 🧰 **Tech Stack**

<table>
  <tr>
    <th align="left">Technology</th>
    <th align="left">Purpose</th>
    <th align="left">Category</th>
  </tr>
  <tr>
    <td><strong>Laravel</strong></td>
    <td>API backend (PHP, Sanctum)</td>
    <td>Backend</td>
  </tr>
  <tr>
    <td><strong>Vue.js</strong></td>
    <td>Frontend SPA</td>
    <td>Frontend</td>
  </tr>
  <tr>
    <td><strong>MySQL</strong></td>
    <td>Database</td>
    <td>Database</td>
  </tr>
  <tr>
    <td><strong>Tailwind CSS</strong></td>
    <td>Styling</td>
    <td>UI/UX</td>
  </tr>
  <tr>
    <td><strong>vue-qrcode-reader</strong></td>
    <td>QR Code Scanning</td>
    <td>Library</td>
  </tr>
  <tr>
    <td><strong>Sanctum</strong></td>
    <td>Authentication</td>
    <td>Security</td>
  </tr>
  <tr>
    <td><strong>Vite</strong></td>
    <td>Frontend Build Tool</td>
    <td>Tooling</td>
  </tr>
</table>

---

## ⚙️ **Setup Instructions**

### 📦 **Backend Setup (Laravel API)**

**Step 1:** Clone the repository
```bash
git clone https://github.com/Araanna/IT-DAYS---ATTENDANCE-MONITORING-SYSTEM.git
cd IT-DAYS---ATTENDANCE-MONITORING-SYSTEM
```

**Step 2:** Navigate to backend and install dependencies
```bash
# Navigate to the backend folder (if structured separately)
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

> ⚠️ **Important:** Ensure MySQL is running (via XAMPP or similar)

### 💻 **Frontend Setup (Vue.js)**

**Step 1:** Install frontend dependencies
```bash
# From the project root or frontend/ folder
npm install
npm run dev
```

> ⚠️ **Configuration:** Make sure the Laravel API base URL is set in `axios.defaults.baseURL` (e.g., `http://localhost:8000/api`)

---

## 👥 **User Roles**

### 🎓 **Attendee Role**
- ✅ Register/Login
- ✅ View personal QR code  
- ✅ Dashboard with personal info

### 🧑‍💼 **SBO Role (Student Body Officer)**
- ✅ Register/Login with role = "sbo"
- ✅ Scan attendee QR codes
- ✅ View all attendees
- ✅ Mark attendance
- 🔄 Export to Google Sheets *(upcoming)*

---

## 🚀 **Contributing to the Project**

> We welcome contributions from developers to improve the system!

### ✅ **How to Contribute**

**1. Fork the repository**

**2. Create a new branch:**
```bash
git checkout -b feature/your-feature-name
```

**3. Make your changes**

**4. Commit and push:**
```bash
git commit -m "Add: your message"
git push origin feature/your-feature-name
```

**5. Open a Pull Request** and describe your changes

### 🔧 **Suggestions for Contribution**

<div align="left">

💌 Add email verification  
🔑 Add Google login  
📱 Enhance mobile responsiveness  
📊 Export attendance to Google Sheets  
🔍 Add filter/search/sort to dashboards  
♿ Improve accessibility (a11y)  

</div>

---

## 📷 **Screenshots**

*Screenshots will be added here once available (Dashboard, QR scan page, registration form, etc.)*

---

## 📃 **License**

**MIT License** — Feel free to use and improve it for educational or organizational purposes.

---

## 🙋‍♀️ **Author**

<div align="left">

**Melanie L. Abalde**  
🎓 BSIT Major in System Development  
📷 Lover of photography and technology  
💡 Open for internships and developer collaboration  

</div>

---

<div align="center">

**⭐ Star this repo if you find it helpful!**

</div>

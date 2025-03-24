# 🧑‍🎓 Course Selection Platform for NSYSU

A full-stack web application designed to enhance the course selection experience for National Sun Yat-sen University (NSYSU) students. This project improves upon the official system by integrating **user reviews**, **course search**, and **admin control**, enabling students to make informed choices based on real user feedback.

> ⚠️ **Note**: This project uses **PHP to render UI pages** (server-side HTML templates) while also handling **backend logic** such as database access. In this structure, PHP serves as both the frontend and backend engine.

---

## 🌐 Overview

- 🔍 Search & filter courses
- 🗂️ View and manage personal course schedule
- ✍️ Comment on professors and view others' reviews
- 📈 Manage course history, grades, and credits
- 🔐 Admin page for managing all tables (account, course info, permissions)
- 🧠 Built-in crawler to update official course data (but it was done by 方敬棠, not include here)

---

## 🛠 Tech Stack

| Layer | Stack |
|-------|-------|
| Frontend | PHP (UI layout & logic), HTML, CSS, JavaScript |
| Backend  | PHP (DB logic), Flask (for ML/NLP chatbot logic) |
| Database | MySQL |
| Automation | Python + Selenium (crawler for NSYSU course site) | 

---

## 📁 Project Structure

| Folder | Description |
|--------|-------------|
| `1_index/` | Homepage and course listing interface |
| `2_crud_course/` | Insert / edit / delete / search for courses & reviews |
| `3_chatbox/` | Chatbot (Flask or PHP prototype) |
| `4_auth/` | Login and signup system |
| `5_admin/` | Admin dashboard and data management |
| `sql/` | SQL schema and optional seed data |
| `crawler/` | Python + Selenium scraper for official course site |
| `report/` | Final project documentation (PDF) |

---

## 🗃️ Database Tables (7 total)

1. `student` – account info, role (admin/visitor)
2. `test` – course data scraped from NSYSU
3. `department` – department code & name
4. `professor_info` – professor background info
5. `professor` – student comments & ratings
6. `class_schedule` – student-selected courses
7. `total_course_record` – course completion records, credits & scores

---

## 🔍 Key Features

### 📌 Student Functions
- Register/Login (auth required for all features)
- Manage course schedule (insert/edit/delete)
- Search courses/professors
- Post/view professor reviews
- Log completed courses and grades

### 🔐 Admin Functions
- Modify **any table** via web interface (with search bar)
- Manage users & permissions
- Edit auto-crawled course data

### 🔁 Backend Integration
- Use `PHP + AJAX` for async data updates
- NLP-based chatbot (original idea, partially implemented with Flask)

---

## 🧪 Crawler Design
- Python + Selenium to log in NSYSU course system
- Handle CAPTCHA manually then automate scraping
- Iterate over paginated table rows (`<tr>`) to extract data
- Export as Excel → Clean → Import to MySQL

---

## 🎥 Demo Video

▶️ [Click to watch project demo](https://youtu.be/x3hON8OKhTY)

---

## 💡 Challenges & Reflection
- PHP ↔️ Python communication (Flask bridge attempted for chatbot)
- Schema redesign during iteration (real-world data had duplicate course codes)
- Handling CAPTCHA during scraping

---

## 📬 Contact

Developers: 呂維軒、張耀仁、方敬棠  
Email: zy84946@gmail.com (Contact person)

---

## ✅ To Do / Potential Extensions
- Complete chatbot integration (PHP ↔ Flask NLP)
- Add rating system to courses (not just professors)
- UI upgrade with Tailwind or Bootstrap
- Real-time conflict detection when selecting courses

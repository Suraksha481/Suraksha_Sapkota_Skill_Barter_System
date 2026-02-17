# Skill Barter System - Teacher/Student Role Differentiation

## Overview

Your Skill Barter System has been upgraded to support differentiated roles for **Teachers** and **Students**. Users can now:
- Register as a **Teacher** (can teach skills and manage resources)
- Register as a **Student** (can learn skills and track progress)
- Register as **Both** (have full access to both teacher and student features)

---

## Key Features

### 🔐 Authentication & Registration

#### Registration Flow
1. Users click "Sign Up"
2. They fill in name, email, password
3. **NEW**: They select their role(s):
   - 🎓 **Student** - "I want to learn new skills"
   - 👨‍🏫 **Teacher** - "I want to teach skills"
   - Both roles can be selected

#### User Model Changes
- `role` field now stores JSON array instead of enum
- Examples: `["student"]`, `["teacher"]`, `["teacher", "student"]`
- Helper methods added:
  - `$user->isTeacher()` - Check if user is a teacher
  - `$user->isStudent()` - Check if user is a student
  - `$user->hasRole($role)` - Check specific role
  - `$user->addRole($role)` - Add a role to existing user
  - `$user->removeRole($role)` - Remove a role

---

## 👨‍🏫 Teacher-Specific Features

### Pages & Routes

| Feature | Route | View |
|---------|-------|------|
| Teacher Dashboard | `/teacher/dashboard` | `teacher.dashboard` |
| Teaching Resources | `/teacher/resources` | `teacher.resources.index` |
| Upload Resource | `/teacher/resources/create` | `teacher.resources.create` |
| Teaching Analytics | `/teacher/analytics` | `teacher.analytics` |

### Teacher Dashboard (`/teacher/dashboard`)
- 📊 Shows teaching overview
- 👥 Number of skills taught
- 🔄 Active teaching sessions
- ⭐ Student ratings
- 📬 Pending student requests
- 📣 Student feedback received

### Resources Management (`/teacher/resources`)
- 📚 Upload teaching materials (PDF, DOC, TXT)
- 📄 Organize by category (Notes, Tutorials, Assignments, Reference)
- 🗑️ Delete resources
- ⬇️ Students can download resources

### Analytics (`/teacher/analytics`)
- 📊 Teaching statistics
- 👥 Total students taught
- ✅ Completed teaching sessions
- ⭐ Average rating from students
- 💬 All feedback received
- 🏆 Top skills taught (with charts)

### Middleware
- Route protection: All teacher routes require `teacher` middleware
- Redirects non-teachers to dashboard with error message

---

## 🎓 Student-Specific Features

### Pages & Routes

| Feature | Route | View |
|---------|-------|------|
| Student Dashboard | `/student/dashboard` | `student.dashboard` |
| Learning Path | `/student/learning-path` | `student.learning-path` |
| Skill Progress | `/student/skill-progress/{id}` | `student.skill-progress` |
| Overall Progress | `/student/progress` | `student.progress` |

### Student Dashboard (`/student/dashboard`)
- 🎓 Learning overview
- 📚 Skills being learned
- 🔄 Active courses
- ✅ Completed courses
- 📝 My learning requests
- 📣 Feedback from teachers

### Learning Path (`/student/learning-path`)
- 📖 All enrolled courses
- 🎯 Skills being studied
- 📊 Course progress tracking
- 👨‍🏫 Filter by teacher

### Skill Progress (`/student/skill-progress/{skillId}`)
- 📈 Progress on specific skill
- 📊 Courses taken for that skill
- ✅ Completion status
- 👥 Teachers for that skill

### Progress Overview (`/student/progress`)
- 📊 Overall learning statistics
- ⏱️ Estimated learning hours
- 📅 Course timeline
- 💬 All feedback from teachers
- 🎯 Skill-by-skill progress breakdown

### Middleware
- Route protection: All student routes require `student` middleware
- Redirects non-students to dashboard with error message

---

## 📌 Shared Features (Both Roles)

These pages work for both teachers and students:

| Feature | Route |
|---------|-------|
| My Skills (teach/learn) | `/my-skills` |
| Profile Edit | `/profile` |
| Find Skills (browse) | `/find-skill` |
| Skill Details | `/skill/{id}` |
| Requests Management | `/requests` |
| Feedback | `/feedback` |
| Rewards & Badges | `/rewards` |
| Premium Membership | `/premium` |

---

## 🎯 Main Dashboard Logic

When users visit `/dashboard`:

- **Teacher only** → Redirects to `/teacher/dashboard`
- **Student only** → Redirects to `/student/dashboard`
- **Both roles** → Shows unified dashboard (`dashboard.unified`) with tabs to access both

---

## 📜 Database Changes

### Migration
Run this to update your database:
```bash
php artisan migrate
```

**Migration File**: `2026_02_10_update_role_to_json.php`

This migration:
1. Adds `role_json` column (temporary)
2. Converts existing roles to JSON array format
3. Drops old `role` column
4. Renames `role_json` to `role`

---

## 🔧 Middleware Registration

All middleware is registered in `Kernel.php`:

```php
'teacher' => \App\Http\Middleware\CheckTeacherRole::class,
'student' => \App\Http\Middleware\CheckStudentRole::class,
```

### Middleware Classes

**CheckTeacherRole.php** - Ensures user has teacher role
**CheckStudentRole.php** - Ensures user has student role

---

## 📱 Updated Navigation

The header (`header.blade.php`) now shows role-specific menu items:

```
For Teachers:
- 👨‍🏫 My Teaching
- 📚 Resources
- 📊 Analytics

For Students:
- 🎓 My Learning
- 📖 Learning Path
- 📈 Progress

Shared:
- 👤 Profile
- ⭐ My Skills
- 📝 Requests
- 🏆 Rewards
- 💎 Premium
```

---

## 🎓 New Controllers

### Teacher Controllers
- **TeacherDashboardController** - Teacher overview and stats
- **TeacherResourcesController** - Upload, manage, delete resources
- **TeacherAnalyticsController** - Teaching analytics and performance

### Student Controllers
- **StudentDashboardController** - Student overview
- **StudentLearningPathController** - Learning courses and progress
- **StudentProgressController** - Overall learning statistics

---

## 📋 New Views

### Teacher Views
```
resources/views/teacher/
├── dashboard.blade.php          # Teacher dashboard
├── analytics.blade.php           # Teaching analytics
└── resources/
    ├── index.blade.php          # Resources list
    └── create.blade.php         # Upload resource form
```

### Student Views
```
resources/views/student/
├── dashboard.blade.php           # Student dashboard
├── learning-path.blade.php       # Enrolled courses
├── skill-progress.blade.php      # Progress on specific skill
└── progress.blade.php            # Overall progress
```

### Shared View
```
resources/views/dashboard/
└── unified.blade.php            # For users with both roles
```

---

## 🚀 Setup Instructions

### 1. Database Migration
```bash
php artisan migrate
```

### 2. View How Users Register
- Navigate to `/register`
- Users see role checkboxes
- They can select Teacher, Student, or Both

### 3. Test Teacher Features
```
1. Register as Teacher
2. Add teaching skills in My Skills
3. Visit /teacher/dashboard
4. Upload resources
5. View analytics
```

### 4. Test Student Features
```
1. Register as Student
2. Add learning skills in My Skills
3. Visit /student/dashboard
4. View learning path
5. Check progress
```

---

## 🔒 Security

- **Middleware Protection**: All role-specific routes are protected
- **Unauthorized Access**: Users trying to access pages without required role are redirected
- **Role Assignment**: Roles selected during registration
- **Profile Creation**: TeacherProfile and StudentProfile are created automatically based on selected roles

---

## 📊 Database Schema

### Users Table Changes
```
BEFORE:
role ENUM('user', 'admin', 'moderator')

AFTER:
role JSON (e.g., ["teacher"] or ["student"] or ["teacher", "student"])
```

### Related Tables
- `teacher_profiles` - Created when user registers as teacher
- `student_profiles` - Created when user registers as student
- `resources` - For storing teacher's uploaded materials

---

## ✅ Checklist for Testing

- [ ] User can register as Teacher only
- [ ] User can register as Student only
- [ ] User can register as Both
- [ ] Teacher dashboard shows correct stats
- [ ] Student dashboard shows correct courses
- [ ] Teacher can upload resources
- [ ] Student can view learning path
- [ ] Unauthorized users can't access role-specific pages
- [ ] Navigation shows correct menu items
- [ ] Unified dashboard works for both roles

---

## 🎨 UI Customization

All new pages include:
- Modern gradient backgrounds
- Card-based layouts
- Progress bars and statistics
- Emoji icons for better UX
- Responsive design (mobile-friendly)
- Consistent color scheme (purple/blue gradients)

---

## 📞 Support

If you need to modify the system:

1. **Add a new teacher feature**: Create controller in `Http/Controllers/`, add route with `teacher` middleware, create view in `teacher/` folder
2. **Add a new student feature**: Same as above, but with `student` middleware and `student/` folder
3. **Shared feature**: No middleware needed, place in appropriate location

---

## 🎉 Summary

Your system now has:
- ✅ Role-based registration
- ✅ Separate dashboards for teachers and students
- ✅ Teacher resource management and analytics
- ✅ Student learning path and progress tracking
- ✅ Unified dashboard for users with both roles
- ✅ Protected routes with role-based middleware
- ✅ Updated navigation with role-specific items
- ✅ Secure access control

Happy teaching and learning! 🎓👨‍🏫

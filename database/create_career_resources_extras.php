<?php
require_once '../includes/db.php';

// 1. Create career_articles table
$pdo->exec("CREATE TABLE IF NOT EXISTS career_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    date DATE,
    category VARCHAR(100),
    link VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// 2. Create career_events table
$pdo->exec("CREATE TABLE IF NOT EXISTS career_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    date DATE,
    type VARCHAR(50),
    time VARCHAR(50),
    spots INT,
    link VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// 3. Create newsletter_subscribers table
$pdo->exec("CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// 4. Create career_faq table
$pdo->exec("CREATE TABLE IF NOT EXISTS career_faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// 5. Insert sample data into career_resources (categories and featured)
$pdo->exec("INSERT IGNORE INTO career_resources (id, title, description, icon, position, status) VALUES
(1, 'Resume & CV', 'Templates, tips, and best practices for creating standout resumes', 'ri-file-text-line', 1, 'category'),
(2, 'Interview Prep', 'Common questions, techniques, and strategies for interview success', 'ri-user-voice-line', 2, 'category'),
(3, 'Skills Development', 'Courses, certifications, and learning paths for career advancement', 'ri-graduation-cap-line', 3, 'category'),
(4, 'Career Planning', 'Goal setting, career paths, and strategic planning guidance', 'ri-briefcase-4-line', 4, 'category'),
(5, 'Networking', 'Building professional relationships and expanding your network', 'ri-share-line', 5, 'category'),
(6, 'Salary Negotiation', 'Strategies for negotiating better compensation and benefits', 'ri-money-dollar-circle-line', 6, 'category'),
(7, 'Professional Resume Template', 'Download our ATS-friendly resume template with expert tips', '../assets/images/resume-template.jpg', 1, 'featured'),
(8, 'Complete Interview Guide', 'Master common interview questions and behavioral techniques', '../assets/images/interview-guide.jpg', 2, 'featured'),
(9, 'Salary Negotiation Masterclass', 'Learn proven strategies to negotiate better compensation', '../assets/images/salary-negotiation.jpg', 3, 'featured')
;");

// 6. Insert sample articles
default:
$pdo->exec("INSERT IGNORE INTO career_articles (id, title, description, image, date, category, link) VALUES
(1, '10 Tips for Remote Work Success', 'Essential strategies to thrive in remote work environments', '../assets/images/remote-work.jpg', '2024-03-15', 'Remote Work', '#'),
(2, 'How to Successfully Switch Careers', 'A step-by-step guide to transitioning to a new industry', '../assets/images/career-switch.jpg', '2024-03-12', 'Career Change', '#'),
(3, 'AI Skills Every Professional Needs', 'Future-proof your career with essential AI competencies', '../assets/images/ai-skills.jpg', '2024-03-10', 'Skills', '#')
;");

// 7. Insert sample events
$pdo->exec("INSERT IGNORE INTO career_events (id, title, description, date, type, time, spots, link) VALUES
(1, 'Resume Writing Workshop', 'Learn to create compelling resumes that get you interviews', '2024-03-25', 'Webinar', '2:00 PM EST', 150, '#'),
(2, 'Interview Mastery', 'Practice interviews with industry experts and get feedback', '2024-04-02', 'Workshop', '6:00 PM EST', 50, '#')
;");

// 8. Insert sample FAQs
$pdo->exec("INSERT IGNORE INTO career_faq (id, question, answer) VALUES
(1, 'How often should I update my resume?', 'It\'s recommended to update your resume every 6-12 months, or whenever you gain new skills, complete projects, or change roles. Keep it current with your latest achievements and experiences.'),
(2, 'What should I include in a cover letter?', 'A strong cover letter should include your motivation for the role, relevant experience, specific achievements, and how you can contribute to the company. Keep it concise and tailored to each position.'),
(3, 'How do I prepare for a behavioral interview?', 'Use the STAR method (Situation, Task, Action, Result) to structure your responses. Prepare specific examples from your experience that demonstrate your skills and achievements.'),
(4, 'When should I start salary negotiations?', 'Wait until you have a job offer before discussing salary. Research market rates for your position and experience level, and be prepared to justify your desired compensation.')
;");

echo "Career resources extra tables and sample data created!"; 
<?php

namespace Database\Seeders;

use App\Models\Chapter;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = [
            [
                'title' => 'Overview of Computing',
                'description' => 'Introduction to the field of computing and its importance in today\'s world.',
                'chapter_number' => 1,
                'image_path' => 'overview_computing.jpg',
            ],
            [
                'title' => 'History of Computing',
                'description' => 'Exploring the evolution of computing from ancient times to the present day.',
                'chapter_number' => 2,
                'image_path' => 'history_computing.jpg',
            ],
            [
                'title' => 'Fundamental Concepts of Computing',
                'description' => 'Understanding basic concepts such as algorithms, data structures, and programming languages.',
                'chapter_number' => 3,
                'image_path' => 'fundamental_concepts.jpg',
            ],
            [
                'title' => 'Hardware Components',
                'description' => 'An overview of the physical components that make up a computer system.',
                'chapter_number' => 4,
                'image_path' => 'hardware_components.jpg',
            ],
            [
                'title' => 'Software Systems',
                'description' => 'Introduction to software systems, including operating systems and application software.',
                'chapter_number' => 5,
                'image_path' => 'software_systems.jpg',
            ],
            [
                'title' => 'Networking and Communication',
                'description' => 'Basics of computer networking, protocols, and communication technologies.',
                'chapter_number' => 6,
                'image_path' => 'networking_communication.jpg',
            ],
            [
                'title' => 'Internet and World Wide Web',
                'description' => 'Understanding the structure and functioning of the internet and the World Wide Web.',
                'chapter_number' => 7,
                'image_path' => 'internet_www.jpg',
            ],
            [
                'title' => 'Introduction to Programming',
                'description' => 'An introduction to programming concepts and problem-solving techniques.',
                'chapter_number' => 8,
                'image_path' => 'introduction_programming.jpg',
            ],
            [
                'title' => 'Data Management',
                'description' => 'Understanding databases, data storage, and retrieval techniques.',
                'chapter_number' => 9,
                'image_path' => 'data_management.jpg',
            ],
            [
                'title' => 'Security and Privacy',
                'description' => 'Overview of security threats, encryption, and privacy issues in computing.',
                'chapter_number' => 10,
                'image_path' => 'security_privacy.jpg',
            ],
            [
                'title' => 'Future Trends in Computing',
                'description' => 'Exploring emerging technologies and future trends shaping the field of computing.',
                'chapter_number' => 11,
                'image_path' => 'future_trends.jpg',
            ],
            // Add more chapters here as needed
        ];

        foreach ($chapters as $chapterData) {
            Chapter::create($chapterData);
        }
    }
}

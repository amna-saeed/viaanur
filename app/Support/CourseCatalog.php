<?php

namespace App\Support;

class CourseCatalog
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        $courses = [
            self::entry('primary-english', [
                'title' => 'Primary English',
                'subtitle' => '(KS1 & KS2)',
                'eyebrow' => 'Primary Subjects · KS1 & KS2',
                'group' => 'primary',
                'icon' => 'english.webp',
                'image' => 'assets/images/banner/english.webp',
                'badge' => 'From £30/hr',
                'price' => '£30/hr',
                'subject_icon' => 'bi-book',
                'description' => 'Build strong literacy foundations through engaging lessons aligned with the UK National Curriculum.',
                'about' => 'Build strong literacy foundations through engaging lessons in reading, writing, spelling, grammar, punctuation, handwriting, comprehension, vocabulary development, and spoken language—aligned with the UK National Curriculum.',
                'learn' => [
                    'Confident reading and comprehension across fiction and non-fiction',
                    'Clear writing with accurate spelling, grammar, and punctuation',
                    'Handwriting fluency and presentation skills',
                    'Vocabulary development and spoken language confidence',
                    'National Curriculum alignment for KS1 and KS2',
                ],
            ]),
            self::entry('primary-maths', [
                'title' => 'Primary Maths',
                'subtitle' => '(KS1 & KS2)',
                'eyebrow' => 'Primary Subjects · KS1 & KS2',
                'group' => 'primary',
                'icon' => 'Maths.webp',
                'image' => 'assets/images/banner/Maths.webp',
                'badge' => 'From £30/hr',
                'price' => '£30/hr',
                'subject_icon' => 'bi-calculator',
                'description' => 'Develop mathematical confidence through number fluency, reasoning, and problem-solving aligned with the UK National Curriculum.',
                'about' => 'Develop mathematical confidence through number fluency, arithmetic, reasoning, problem-solving, fractions, measurement, geometry, statistics, and mental maths strategies in line with the UK National Curriculum.',
                'learn' => [
                    'Number fluency and secure arithmetic skills',
                    'Reasoning and multi-step problem solving',
                    'Fractions, measurement, geometry, and statistics',
                    'Mental maths strategies for everyday application',
                    'Confidence with UK National Curriculum expectations',
                ],
            ]),
            self::entry('eleven-plus-preparation', [
                'title' => '11+ Preparation',
                'eyebrow' => 'Primary · Entrance preparation',
                'group' => 'primary',
                'icon' => 'university.webp',
                'image' => 'assets/images/banner/university.webp',
                'badge' => 'From £35/hr',
                'price' => '£35/hr',
                'description' => 'Targeted preparation for grammar school and independent school entrance assessments.',
                'about' => 'Targeted preparation for grammar school and independent school entrance assessments, including verbal reasoning, non-verbal reasoning, English, mathematics, comprehension, exam technique, and confidence building.',
                'learn' => [
                    'Verbal and non-verbal reasoning strategies',
                    'English and mathematics for entrance papers',
                    'Comprehension skills and timed practice',
                    'Exam technique and confidence building',
                    'Structured preparation for selective entry',
                ],
            ]),
            self::entry('other-entrance-exams', [
                'title' => 'Other Entrance Exams',
                'eyebrow' => 'Primary · Entrance preparation',
                'group' => 'primary',
                'icon' => 'university.webp',
                'image' => 'assets/images/banner/wi.webp',
                'badge' => 'From £35/hr',
                'price' => '£35/hr',
                'description' => 'Tailored preparation for independent school admissions and selective entry assessments.',
                'about' => 'Tailored preparation for independent school admissions and selective entry assessments, with bespoke support in English, mathematics, reasoning, interview preparation, and exam strategy.',
                'learn' => [
                    'Bespoke English and mathematics support',
                    'Reasoning and interview preparation',
                    'Exam strategy for independent admissions',
                    'Confidence for selective entry assessments',
                    'Personalised plan for each learner\'s target schools',
                ],
            ]),
            self::entry('secondary-english', [
                'title' => 'Secondary English',
                'subtitle' => '(KS3)',
                'eyebrow' => 'Secondary Subjects · KS3',
                'group' => 'secondary',
                'icon' => 'english.webp',
                'image' => 'assets/images/banner/english.webp',
                'badge' => 'From £32/hr',
                'price' => '£32/hr',
                'description' => 'Strengthen analytical reading, writing, and critical thinking in preparation for GCSE success.',
                'about' => 'Strengthen analytical reading, creative and transactional writing, grammar, vocabulary, literary analysis, comprehension, speaking, and critical thinking in preparation for GCSE success.',
                'learn' => [
                    'Analytical reading and literary analysis',
                    'Creative and transactional writing',
                    'Grammar, vocabulary, and comprehension',
                    'Speaking and critical thinking skills',
                    'Strong foundations for GCSE English',
                ],
            ]),
            self::entry('secondary-maths', [
                'title' => 'Secondary Maths',
                'subtitle' => '(KS3)',
                'eyebrow' => 'Secondary Subjects · KS3',
                'group' => 'secondary',
                'icon' => 'Maths.webp',
                'image' => 'assets/images/banner/Maths.webp',
                'badge' => 'From £32/hr',
                'price' => '£32/hr',
                'description' => 'Consolidate core mathematical knowledge including algebra, geometry, and multi-step problem solving.',
                'about' => 'Consolidate core mathematical knowledge including number, algebra, ratio, proportion, geometry, statistics, probability, reasoning, and multi-step problem solving.',
                'learn' => [
                    'Number, algebra, ratio, and proportion',
                    'Geometry, statistics, and probability',
                    'Multi-step reasoning and problem solving',
                    'Secure KS3 knowledge before GCSE',
                    'Exam-ready mathematical thinking',
                ],
            ]),
            self::entry('secondary-science', [
                'title' => 'Secondary Science',
                'subtitle' => '(KS3)',
                'eyebrow' => 'Secondary Subjects · KS3',
                'group' => 'secondary',
                'icon' => 'socialmedia.webp',
                'image' => 'assets/images/banner/socialmedia (1).webp',
                'badge' => 'From £32/hr',
                'price' => '£32/hr',
                'description' => 'Explore biology, chemistry, and physics with strong scientific knowledge and investigative skills.',
                'about' => 'Explore key concepts across biology, chemistry, and physics, building scientific knowledge, practical understanding, investigative skills, and exam readiness.',
                'learn' => [
                    'Core concepts in biology, chemistry, and physics',
                    'Practical understanding and investigative skills',
                    'Scientific vocabulary and application',
                    'Exam readiness across KS3 science',
                    'Confidence for GCSE science pathways',
                ],
            ]),
            self::entry('gcse-english', [
                'title' => 'GCSE English',
                'eyebrow' => 'GCSE · All major UK exam boards',
                'group' => 'gcse',
                'icon' => 'english.webp',
                'image' => 'assets/images/banner/english.webp',
                'badge' => 'From £35/hr',
                'price' => '£35/hr',
                'description' => 'Comprehensive GCSE English Language and Literature support across AQA, Edexcel, OCR, Eduqas, and WJEC.',
                'about' => 'Comprehensive support in English Language and Literature, including reading analysis, essay writing, unseen texts, poetry, creative writing, transactional writing, grammar, structure, and exam technique. All major UK exam boards supported including AQA, Edexcel/Pearson, OCR, Eduqas, and WJEC.',
                'learn' => [
                    'Reading analysis and essay writing',
                    'Unseen texts, poetry, and literature skills',
                    'Creative and transactional writing',
                    'Grammar, structure, and exam technique',
                    'Board-specific preparation (AQA, Edexcel, OCR, Eduqas, WJEC)',
                ],
            ]),
            self::entry('gcse-maths', [
                'title' => 'GCSE Maths',
                'eyebrow' => 'GCSE · All major UK exam boards',
                'group' => 'gcse',
                'icon' => 'Maths.webp',
                'image' => 'assets/images/banner/wi.webp',
                'badge' => 'From £35/hr',
                'price' => '£35/hr',
                'description' => 'Full GCSE Maths curriculum support covering algebra, geometry, statistics, and exam preparation.',
                'about' => 'Full curriculum support covering number, algebra, ratio, geometry, trigonometry, probability, statistics, problem solving, reasoning, and exam preparation across all UK exam boards including AQA, Edexcel/Pearson, OCR, Eduqas, and WJEC.',
                'learn' => [
                    'Number, algebra, ratio, and trigonometry',
                    'Geometry, probability, and statistics',
                    'Problem solving and reasoning',
                    'Exam preparation and past-paper technique',
                    'Support for all major UK exam boards',
                ],
            ]),
            self::entry('gcse-science', [
                'title' => 'GCSE Science',
                'eyebrow' => 'GCSE · All major UK exam boards',
                'group' => 'gcse',
                'icon' => 'university.webp',
                'image' => 'assets/images/banner/university.webp',
                'badge' => 'From £35/hr',
                'price' => '£35/hr',
                'description' => 'Specialist tuition in Combined and Triple Science with board-specific exam preparation.',
                'about' => 'Specialist tuition in Combined and Triple Science, covering biology, chemistry, and physics topics alongside required practicals, scientific application, exam technique, and board-specific preparation. All major UK exam boards supported.',
                'learn' => [
                    'Biology, chemistry, and physics topic mastery',
                    'Required practicals and scientific application',
                    'Combined and Triple Science pathways',
                    'Exam technique and board-specific preparation',
                    'Confidence across AQA, Edexcel, OCR, Eduqas, and WJEC',
                ],
            ]),
            self::entry('esol-foundation', [
                'title' => 'ESOL Foundation',
                'eyebrow' => 'ESOL',
                'group' => 'esol',
                'icon' => 'esol.webp',
                'image' => 'assets/images/banner/esol.webp',
                'badge' => 'From £30/hr',
                'price' => '£30/hr',
                'description' => 'Build English proficiency in speaking, listening, reading, and writing for everyday life and study.',
                'about' => 'Support for learners developing English language proficiency in speaking, listening, reading, and writing, with tailored lessons designed to build confidence for everyday communication, work, or formal study.',
                'learn' => [
                    'Speaking and listening for real-life situations',
                    'Reading and writing for everyday communication',
                    'Confidence for work or formal study',
                    'Tailored lessons at your level and pace',
                    'Practical English for daily life in the UK',
                ],
            ]),
            self::entry('adult-casual-learners', [
                'title' => 'Adult Casual Learners',
                'eyebrow' => 'Adult Learning / Skills',
                'group' => 'adult',
                'icon' => 'Web design.webp',
                'image' => 'assets/images/banner/socialmedia (1).webp',
                'badge' => 'From £30/hr',
                'price' => '£30/hr',
                'description' => 'Flexible learning tailored to literacy, numeracy, communication, and personal development goals.',
                'about' => 'Flexible learning tailored to adult learners seeking support with literacy, numeracy, English communication, confidence building, digital basics, or personal development goals.',
                'learn' => [
                    'Literacy and numeracy at your own pace',
                    'English communication and confidence',
                    'Digital basics and everyday skills',
                    'Personal development goals',
                    'Flexible sessions around your schedule',
                ],
            ]),
            self::entry('social-media-content-creation', [
                'title' => 'Social Media – Content Creation',
                'eyebrow' => 'Adult Learning / Skills',
                'group' => 'adult',
                'icon' => 'socialmedia.webp',
                'image' => 'assets/images/banner/socialmedia (1).webp',
                'badge' => 'From £30/hr',
                'price' => '£30/hr',
                'description' => 'Practical coaching in content planning, branding, and audience engagement for personal or business growth.',
                'about' => 'Practical coaching in content planning, branding, social media strategy, audience engagement, visual storytelling, and creating compelling content for personal brands or business growth.',
                'learn' => [
                    'Content planning and brand positioning',
                    'Social media strategy and audience engagement',
                    'Visual storytelling and compelling content',
                    'Growth for personal brands or businesses',
                    'Practical skills you can apply immediately',
                ],
            ]),
            self::entry('islamic-studies', [
                'title' => 'Islamic Studies',
                'eyebrow' => 'Faith & Spiritual Learning',
                'group' => 'faith',
                'icon' => 'quran.webp',
                'image' => 'assets/images/banner/quran (1).webp',
                'badge' => 'From £20/hr',
                'price' => '£20/hr',
                'description' => 'Age-appropriate lessons in Islamic faith, values, worship, and character for everyday life.',
                'about' => 'Develop a meaningful understanding of Islamic faith, values, and practice through age-appropriate lessons covering core beliefs (Aqeedah), worship (Salah, fasting, purification), prophetic stories, Islamic manners and character, duas, and practical application in daily life.',
                'learn' => [
                    'Core beliefs (Aqeedah) and worship fundamentals',
                    'Prophetic stories and Islamic manners',
                    'Duas and practical application in daily life',
                    'Age-appropriate, respectful teaching',
                    'Character development rooted in faith',
                ],
            ]),
            self::entry('quran-reading-beginners', [
                'title' => "Beginners – Qur'an Reading (Qaa'idah)",
                'eyebrow' => 'Faith & Spiritual Learning',
                'group' => 'faith',
                'icon' => 'Quran Memorizing.webp',
                'image' => 'assets/images/banner/quran (1).webp',
                'badge' => 'From £20/hr',
                'price' => '£20/hr',
                'description' => 'Structured introduction to Arabic letters, pronunciation, and foundational Qur\'an reading fluency.',
                'about' => 'A structured introduction to Qur\'an reading for beginners, focusing on Arabic letter recognition, pronunciation (makharij), blending, vowel sounds, and foundational reading fluency to prepare learners for confident Qur\'anic recitation.',
                'learn' => [
                    'Arabic letter recognition and makharij',
                    'Blending and vowel sounds (Qaa\'idah)',
                    'Foundational reading fluency',
                    'Step-by-step progression for beginners',
                    'Preparation for confident Qur\'anic recitation',
                ],
            ]),
            self::entry('quran-reading-tajweed', [
                'title' => "Intermediate – Qur'an Reading (Tajweed)",
                'eyebrow' => 'Faith & Spiritual Learning',
                'group' => 'faith',
                'icon' => 'Quran Memorizing.webp',
                'image' => 'assets/images/banner/quran (1).webp',
                'badge' => 'From £20/hr',
                'price' => '£20/hr',
                'description' => 'Build fluency and accuracy in Qur\'an recitation through guided tajweed instruction.',
                'about' => 'Build confidence and fluency in Qur\'an recitation through guided tajweed instruction, focusing on pronunciation rules, articulation points, elongation, rhythm, recitation accuracy, and developing a beautiful and correct reading style.',
                'learn' => [
                    'Tajweed rules and articulation points',
                    'Elongation, rhythm, and recitation accuracy',
                    'Correct and beautiful reading style',
                    'Guided practice with expert feedback',
                    'Greater confidence in daily recitation',
                ],
            ]),
            self::entry('quran-hifdh-programme', [
                'title' => "Qur'an Hifdh Programme",
                'eyebrow' => 'Faith & Spiritual Learning',
                'group' => 'faith',
                'icon' => 'Quran Memorizing.webp',
                'image' => 'assets/images/banner/quran (1).webp',
                'badge' => 'From £20/hr',
                'price' => '£20/hr',
                'description' => 'Personalised Qur\'an memorisation with structured repetition, revision, and spiritual encouragement.',
                'about' => 'A personalised memorisation programme supporting learners in the memorisation (hifdh) of the Qur\'an through structured repetition, revision techniques, recitation correction, retention strategies, goal setting, and spiritual encouragement.',
                'learn' => [
                    'Structured memorisation and revision techniques',
                    'Recitation correction and retention strategies',
                    'Personalised goals and progress tracking',
                    'Consistent support and spiritual encouragement',
                    'Long-term retention of memorised portions',
                ],
            ]),
        ];

        foreach ($courses as $slug => $course) {
            $courses[$slug]['slug'] = $slug;
            $courses[$slug]['url'] = route('courses.detail', $slug);
            $courses[$slug]['subjects'] = $course['subjects'] ?? [
                [
                    'name' => $course['title'],
                    'price' => $course['price'],
                    'icon' => $course['subject_icon'] ?? 'bi-book',
                ],
            ];
        }

        return $courses;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function entry(string $slug, array $data): array
    {
        return array_merge(['slug' => $slug], $data);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function get(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }

    /**
     * Slider / categories component data.
     *
     * @return list<array<string, mixed>>
     */
    public static function forSlider(): array
    {
        return array_values(array_map(static function (array $course) {
            return [
                'title' => $course['title'],
                'subtitle' => $course['subtitle'] ?? '',
                'icon' => $course['icon'],
                'slug' => $course['slug'],
                'url' => $course['url'],
            ];
        }, self::all()));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function related(string $currentSlug, int $limit = 3): array
    {
        $all = self::all();
        $current = $all[$currentSlug] ?? null;

        if (! $current) {
            return [];
        }

        $group = $current['group'] ?? '';
        $others = array_filter($all, static fn ($c, $slug) => $slug !== $currentSlug, ARRAY_FILTER_USE_BOTH);

        usort($others, static function ($a, $b) use ($group) {
            $aSame = ($a['group'] ?? '') === $group ? 0 : 1;
            $bSame = ($b['group'] ?? '') === $group ? 0 : 1;

            return $aSame <=> $bSame;
        });

        return array_map(static function (array $course) {
            return [
                'title' => $course['title'],
                'description' => $course['description'],
                'image' => $course['image'],
                'price' => $course['price'],
                'url' => $course['url'],
            ];
        }, array_slice(array_values($others), 0, $limit));
    }
}

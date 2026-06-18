<?php

namespace App\Support;

use App\Models\Course;

class CourseApplicationMapper
{
    /** Legacy apply-form values kept for older applications in the database. */
    private const LEGACY_LABELS = [
        'social-media' => 'Social Media – Content Creation',
        'esol' => 'ESOL Foundation',
        'english' => 'Primary English',
    ];

    /** @var array<string, array<int, string>> */
    private const TITLE_HINTS = [
        'gcse-maths' => ['Math', 'Mathematics'],
        'gcse-english' => ['English'],
        'gcse-science' => ['Science'],
        'islamic-studies' => ['Islamic'],
        'esol-foundation' => ['ESOL'],
        'esol' => ['ESOL'],
        'primary-english' => ['English'],
        'primary-maths' => ['Math', 'Mathematics'],
        'secondary-english' => ['English'],
        'secondary-maths' => ['Math', 'Mathematics'],
        'secondary-science' => ['Science'],
        'social-media-content-creation' => ['Social Media'],
        'social-media' => ['Social Media'],
        'adult-casual-learners' => ['Adult Casual'],
        'quran-reading-beginners' => ['Quran', "Qur'an"],
        'quran-reading-tajweed' => ['Quran', "Qur'an", 'Tajweed'],
        'quran-hifdh-programme' => ['Quran', "Qur'an", 'Hifdh'],
    ];

    public static function label(string $courseKey): string
    {
        $catalog = CourseCatalog::get($courseKey);
        if ($catalog) {
            $label = $catalog['title'];
            if (! empty($catalog['subtitle'])) {
                $label .= ' '.$catalog['subtitle'];
            }

            return $label;
        }

        return self::LEGACY_LABELS[$courseKey]
            ?? ucwords(str_replace(['-', '_'], ' ', $courseKey));
    }

    public static function resolveCourse(?string $courseKey): ?Course
    {
        if ($courseKey === null || $courseKey === '') {
            return null;
        }

        $bySlug = Course::query()->where('slug', $courseKey)->first();
        if ($bySlug) {
            return $bySlug;
        }

        $catalog = CourseCatalog::get($courseKey);
        if ($catalog) {
            $byExactTitle = Course::query()->where('title', $catalog['title'])->first();
            if ($byExactTitle) {
                return $byExactTitle;
            }
        }

        foreach (self::TITLE_HINTS[$courseKey] ?? [] as $hint) {
            $byTitle = Course::query()
                ->where('title', 'like', '%'.$hint.'%')
                ->first();

            if ($byTitle) {
                return $byTitle;
            }
        }

        return null;
    }

    public static function resolveOrCreateLmsCourse(?string $courseKey): ?Course
    {
        $existing = self::resolveCourse($courseKey);
        if ($existing) {
            return $existing;
        }

        $catalog = CourseCatalog::get($courseKey);
        if (! $catalog) {
            return null;
        }

        return Course::firstOrCreate(
            ['slug' => $courseKey],
            [
                'title' => $catalog['title'],
                'description' => $catalog['description'] ?? null,
                'is_published' => false,
            ]
        );
    }

    public static function resolveCourseId(?string $courseKey): ?int
    {
        return optional(self::resolveCourse($courseKey))->id;
    }
}

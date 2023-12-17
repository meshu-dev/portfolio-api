<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Project,
    Repository,
    Technology,
    Type,
    Image,
    ImageThumbnail
};

class DataSeeder extends Seeder
{
    protected const PROJECTS = [
        ['name' => 'CV', 'description' => 'Digital version of my CV', 'url' => 'https://cv.meshu.app', 'order' => 1, 'type' => 'Javascript', 'technologies' => ['React', 'Next.js', 'MongoDB'], 'repositories' => ['CV']],
        ['name' => 'Mailer', 'description' => 'E-mailer sending service', 'url' => 'https://mailer.meshu.app', 'order' => 2, 'type' => 'Javascript', 'technologies' => ['React', 'Next.js'], 'repositories' => ['Mailer']],
        ['name' => 'Sites', 'description' => 'Tool to manage websites', 'url' => 'https://sites.meshu.app', 'order' => 3, 'type' => 'Javascript', 'technologies' => ['React', 'Next.js', 'PostgreSQL'], 'repositories' => ['Sites']],
        ['name' => 'Crypto', 'description' => 'Realtime cryptocurrency price list', 'url' => 'https://crypto.meshu.app', 'order' => 4, 'type' => 'Javascript', 'technologies' => ['React', 'Next.js', 'MongoDB'], 'repositories' => ['Crypto', 'Crypto API']],
        ['name' => 'Backlog', 'description' => 'Backlog manager for movies and TV shows', 'url' => 'https://backlog.meshu.app', 'order' => 1, 'type' => 'PHP', 'technologies' => ['Laravel', 'MySQL', 'Vue.js'], 'repositories' => ['Backlog', 'Backlog API']],
        ['name' => 'Admin', 'description' => 'Admin panel to manage data', 'url' => 'https://admin.meshu.app', 'order' => 2, 'type' => 'PHP', 'technologies' => ['Laravel', 'MySQL', 'React'], 'repositories' => ['Admin', 'Portfolio API']],
        ['name' => 'RequireDev', 'description' => 'PHP / Javasript tutorial blog', 'url' => 'https://www.requiredev.com', 'order' => 3, 'type' => 'PHP', 'technologies' => ['Wordpress', 'React', 'Next.js', 'GraphQL'], 'repositories' => ['RequireDev', 'RequireDev WP']],
    ];
    protected const REPOSITORIES = [
        ['name' => 'CV',            'url' => 'https://github.com/meshu-dev/cv'],
        ['name' => 'Mailer',        'url' => 'https://github.com/meshu-dev/mailer'],
        ['name' => 'Sites',         'url' => 'https://github.com/meshu-dev/sites'],
        ['name' => 'Crypto',        'url' => 'https://github.com/meshu-dev/crypto'],
        ['name' => 'Crypto API',    'url' => 'https://github.com/meshu-dev/crypto-api'],
        ['name' => 'Backlog',       'url' => 'https://github.com/meshu-dev/backlog'],
        ['name' => 'Backlog API',   'url' => 'https://github.com/meshu-dev/backlog-api'],
        ['name' => 'Admin',         'url' => 'https://github.com/meshu-dev/admin'],
        ['name' => 'Portfolio API', 'url' => 'https://github.com/meshu-dev/portfolio-api '],
        ['name' => 'RequireDev',    'url' => 'https://github.com/meshu-dev/requiredev'],
        ['name' => 'RequireDev WP', 'url' => 'https://github.com/meshu-dev/requiredev-wp'],
    ];
    protected const TECHNOLOGIES = ['Laravel', 'Wordpress', 'Node.js', 'MySQL', 'MongoDB', 'PostgreSQL', 'Express.js', 'Fastify', 'Angular', 'React', 'Next.js', 'Vue.js', 'Nuxt.js', 'GraphQL'];
    protected const TYPES = ['PHP', 'Javascript'];

    public function run()
    {
        $user = User::firstOrFail();

        $typeIds       = $this->createTypes($user->id);
        $technologyIds = $this->createTechnologies($user->id);
        $repositoryIds = $this->createRepositories($user->id);
    
        foreach (self::PROJECTS as $projectData) {
            $project = Project::create([
                'user_id'     => $user->id,
                'type_id'     => $typeIds[$projectData['type']],
                'name'        => $projectData['name'],
                'description' => $projectData['description'],
                'url'         => $projectData['url'],
                'order'       => $projectData['order']
            ]);

            $projectTechnologyIds = array_map(fn($technology) => $technologyIds[$technology], $projectData['technologies']);
            $project->technologies()->attach($projectTechnologyIds);

            $projectRepositoryIds = array_map(fn($repository) => $repositoryIds[$repository], $projectData['repositories']);
            $project->repositories()->attach($projectRepositoryIds);

            $project->save();
        }
    }

    protected function createTypes(int $userId): array
    {
        $typeIds = [];

        foreach (self::TYPES as $typeName) {
            $type = Type::create(['user_id' => $userId, 'name' => $typeName]);
            $typeIds[$typeName] = $type->id;
        }
        return $typeIds;
    }

    protected function createTechnologies(int $userId): array
    {
        $technologyIds = [];

        foreach (self::TECHNOLOGIES as $technologyName) {
            $technology = Technology::create(['user_id' => $userId, 'name' => $technologyName]);
            $technologyIds[$technologyName] = $technology->id;
        }
        return $technologyIds;
    }

    protected function createRepositories(int $userId): array
    {
        $repositoryIds = [];

        foreach (self::REPOSITORIES as $repositoryData) {
            $repository = Repository::create([
                'user_id' => $userId,
                'name' => $repositoryData['name'],
                'url' => $repositoryData['url']
            ]);
            $repositoryIds[$repositoryData['name']] = $repository->id;
        }
        return $repositoryIds;
    }

    protected function createProjects(int $userId): array
    {
        $repositoryIds = [];

        foreach (self::REPOSITORIES as $repositoryData) {
            $repository = Repository::create([
                'user_id' => $userId,
                'name' => $repositoryData['name'],
                'url' => $repositoryData['url']
            ]);
            $repositoryIds[$repositoryData['name']] = $repository->id;
        }
        return $repositoryIds;
    }
}



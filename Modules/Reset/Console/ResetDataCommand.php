<?php namespace Modules\Reset\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Modules\Block\Repositories\BlockRepository;
use Modules\Blog\Repositories\CategoryRepository;
use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Repositories\TagRepository;
use Modules\Media\Repositories\FileRepository;
use Modules\Menu\Repositories\MenuRepository;
use Modules\Page\Repositories\PageRepository;
use Modules\Setting\Repositories\SettingRepository;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class ResetDataCommand extends Command
{
    protected $name = 'reset:tables';
    protected $description = 'Reset application tables';

    /**
     * @var PageRepository
     */
    private $page;
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var SettingRepository
     */
    private $setting;
    /**
     * @var MenuRepository
     */
    private $menu;
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var CategoryRepository
     */
    private $category;
    /**
     * @var PostRepository
     */
    private $post;
    /**
     * @var TagRepository
     */
    private $tag;
    /**
     * @var BlockRepository
     */
    private $block;
    /**
     * @var RoleRepository
     */
    private $role;

    public function __construct(
        UserRepository $user, PageRepository $page, SettingRepository $setting, MenuRepository $menu,
        FileRepository $file, PostRepository $post, CategoryRepository $category, TagRepository $tag,
        BlockRepository $block, RoleRepository $role
    )
    {
        parent::__construct();
        $this->page = $page;
        $this->user = $user;
        $this->setting = $setting;
        $this->menu = $menu;
        $this->file = $file;
        $this->category = $category;
        $this->post = $post;
        $this->tag = $tag;
        $this->block = $block;
        $this->role = $role;
    }

    public function fire()
    {
        $this->emptyUserTables();
        $this->emptySettingsTable();
        $this->emptyMenuTable();
        $this->emptyMedia();
        $this->emptyPagesTable();
        $this->emptyBlogTables();
        $this->emptyBlockTables();

        Artisan::call('module:seed', ['module' => 'Setting', '--force' => true]);
        Artisan::call('module:seed', ['module' => 'Page', '--force' => true]);
        Artisan::call('db:seed', ['--class' => 'Modules\User\Database\Seeders\SentryGroupSeedTableSeeder', '--force' => true]);
        Artisan::call('module:seed', ['module' => 'Reset', '--force' => true]);
        $this->addPermissionsToAdminRole();

        $this->info('Everything is reset.');
    }

    /**
     *
     */
    private function emptyUserTables()
    {
        foreach ($this->user->all() as $user) {
            $this->user->delete($user->id);
        }
        foreach ($this->role->all() as $role) {
            $this->role->delete($role->id);
        }
    }

    /**
     *
     */
    private function emptySettingsTable()
    {
        foreach ($this->setting->all() as $setting) {
            $this->setting->destroy($setting);
        }
    }

    /**
     *
     */
    private function emptyMenuTable()
    {
        foreach ($this->menu->all() as $menu) {
            $this->menu->destroy($menu);
        }
    }

    /**
     *
     */
    private function emptyMedia()
    {
        foreach ($this->file->all() as $file) {
            $this->file->destroy($file);
        }
    }

    /**
     *
     */
    private function emptyPagesTable()
    {
        foreach ($this->page->all() as $page) {
            $this->page->destroy($page);
        }
    }

    /**
     *
     */
    private function emptyBlogTables()
    {
        foreach ($this->post->all() as $post) {
            $this->post->destroy($post);
        }
        foreach ($this->category->all() as $category) {
            $this->category->destroy($category);
        }
        foreach ($this->tag->all() as $tag) {
            $this->tag->destroy($tag);
        }
    }

    /**
     *
     */
    private function emptyBlockTables()
    {
        foreach ($this->block->all() as $block) {
            $this->block->destroy($block);
        }
    }

    private function addPermissionsToAdminRole()
    {
        $data = [
            'permissions' => [
                'block.blocks.index' => true,
                'block.blocks.create' => true,
                'block.blocks.store' => true,
                'block.blocks.edit' => true,
                'block.blocks.update' => true,
                'block.blocks.destroy' => true,
                "blog.posts.index" => true,
                "blog.posts.create" => true,
                "blog.posts.store" => true,
                "blog.posts.edit" => true,
                "blog.posts.update" => true,
                "blog.posts.destroy" => true,
                "blog.categories.index" => true,
                "blog.categories.create" => true,
                "blog.categories.store" => true,
                "blog.categories.edit" => true,
                "blog.categories.update" => true,
                "blog.categories.destroy" => true,
                "blog.tags.index" => true,
                "blog.tags.create" => true,
                "blog.tags.store" => true,
                "blog.tags.edit" => true,
                "blog.tags.update" => true,
                "blog.tags.destroy" => true,
            ],
        ];
        $adminRole = $this->role->findByName('Admin');

        $this->role->update($adminRole->id, $data);
    }
}

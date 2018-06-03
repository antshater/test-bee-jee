<?php

namespace App\Controllers;


use App\Models\Task;
use App\Widgets\ListView;
use Core\App;
use Core\Auth;
use Core\Controller;
use Core\Exceptions\NotAllowedException;
use Core\Exceptions\NotFoundException;
use Core\Helpers\ArrayHelper;
use Core\Request\UploadedImage;
use Intervention\Image\Image;

/**
 * Class TasksController
 * @property
 */
class TasksController extends Controller
{
    public function index()
    {
        $listView = new ListView(
            Task::class,
            [
                ['user_name', 'Имя пользователя'],
                ['email', 'Email'],
                ['description', 'Описание', false],
                ['completed', 'Статус']
            ],
            $this->request
        );
        $params = compact('page', 'order', 'direction');
        $this->view('task/index', compact('listView', 'params', 'pageCount', 'columns'));
    }

    public function create()
    {
        $task = new Task();

        if ($form = $this->request->post('task')) {
            $task = new Task($form);
            if ($file = $this->request->image('file')) {
                $image = $this->prepareImage($file);
                $file_url = $file->md5() . '.' . $file->extension();
                $image->save(App::filePath($file_url));
                $task->image = '/assets/files/' . $file_url;
            }

            $task->save();
            $this->redirect('/');
        }

        $this->view('task/form', compact('task'));
    }

    private function prepareImage(UploadedImage $file): Image
    {
        $allowed_width = App::config('images.allowed_sizes.width');
        $allowed_height = App::config('images.allowed_sizes.height');
        if (
            $file->image()->getWidth() > $allowed_width ||
            $file->image()->getHeight() > $allowed_height
        ) {
            return $file->image()->fit($allowed_width, $allowed_height);
        }

        return $file->image();
    }

    public function edit()
    {
        if (! Auth::isAdmin()) {
            throw new NotAllowedException('У вас нет прав для редактирования задач');
        }

        $id = $this->request->get('id');
        $task = Task::find($id);
        if (! $task) {
            throw new NotFoundException("Задача #$id не найдена");
        }

        if ($form = $this->request->post('task')) {
            $task->completed = (int) ArrayHelper::extract($form, 'completed');
            $task->description = ArrayHelper::extract($form, 'description');
            $task->save();
            $this->redirect('/');
        }

        $this->view('task/form', compact('task'));
    }
}

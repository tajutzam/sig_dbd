<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Artikel;
use CodeIgniter\HTTP\ResponseInterface;

class ArtikelController extends BaseController
{
    public function index()
    {
        $model = new Artikel();
        $data['artikels'] = $model->findAll();
        return view('pages/artikel/index', $data);
    }


    public function create()
    {
        return view('pages/artikel/create');
    }


    public function store()
    {
        var_dump('oke');
        $model = new Artikel();

        // Validate input data
        if (!$this->validate([
            'judul' => 'required|min_length[3]',
            'author' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]',
        ])) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            // Store the image in the 'public/uploads' folder
            $file->move(WRITEPATH . '../public/uploads', $imageName);  // Adjust path to store in 'public/uploads'
        } else {
            $imageName = null;
        }

        // Save the article data
        $model->save([
            'judul' => $this->request->getPost('judul'),
            'image' => $imageName,
            'author' => $this->request->getPost('author'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/artikel')->with('success', 'Berhasil menambahkan data artikel');
    }

    public function edit($id)
    {
        $model = new Artikel();
        $artikel = $model->find($id);

        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }

        return view('pages/artikel/edit', ['artikel' => $artikel]);
    }


    public function update($id)
    {
        $model = new Artikel();

        // Validate input data
        if (!$this->validate([
            'judul' => 'required|min_length[3]',
            'author' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
            'image' => 'is_image[image]|max_size[image,2048]',
        ])) {
            $errorMessages = implode(', ', $this->validator->getErrors());
            session()->setFlashdata('error', $errorMessages);
            return redirect()->back()->withInput();
        }

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate a new name for the image
            $imageName = $file->getRandomName();
            // Move the image to public/uploads
            $file->move(WRITEPATH . '../public/uploads', $imageName);
        } else {
            // If no new image uploaded, keep the current image
            $imageName = $this->request->getPost('old_image');
        }

        // Update the article data
        $model->update($id, [
            'judul' => $this->request->getPost('judul'),
            'image' => $imageName,
            'author' => $this->request->getPost('author'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diperbarui');
    }

    public function delete($id)
    {
        $model = new Artikel();

        // Find the article by ID
        $artikel = $model->find($id);

        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel not found');
        }

        // Delete the image from the public/uploads folder if it exists
        if ($artikel['image'] && file_exists(WRITEPATH . '../public/uploads/' . $artikel['image'])) {
            unlink(WRITEPATH . '../public/uploads/' . $artikel['image']);
        }

        // Delete the article from the database
        $model->delete($id);

        // Redirect to the articles list with a success message
        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus');
    }
}

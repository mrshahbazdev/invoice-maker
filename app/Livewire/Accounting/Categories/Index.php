<?php

namespace App\Livewire\Accounting\Categories;

use Livewire\Component;
use App\Models\AccountingCategory;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $categories;
    public $name, $type = 'expense', $posting_rule, $categoryId;
    public $isEditing = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:income,expense',
        'posting_rule' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = AccountingCategory::where('business_id', Auth::user()->business->id)
            ->orderBy('name')
            ->get();
    }

    public function openModal($id = null)
    {
        $this->resetInputFields();
        if ($id) {
            $this->isEditing = true;
            $this->categoryId = $id;
            $category = AccountingCategory::find($id);
            $this->name = $category->name;
            $this->type = $category->type;
            $this->posting_rule = $category->posting_rule;
        } else {
            $this->isEditing = false;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->type = 'expense';
        $this->posting_rule = '';
        $this->categoryId = null;
    }

    public function save()
    {
        $this->validate();

        AccountingCategory::updateOrCreate(
            ['id' => $this->categoryId],
            [
                'business_id' => Auth::user()->business->id,
                'name' => $this->name,
                'type' => $this->type,
                'posting_rule' => $this->posting_rule,
            ]
        );

        session()->flash('message', $this->categoryId ? 'Category updated successfully.' : 'Category created successfully.');
        $this->closeModal();
        $this->loadCategories();
    }

    public function delete($id)
    {
        AccountingCategory::find($id)->delete();
        session()->flash('message', 'Category deleted successfully.');
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.accounting.categories.index');
    }
}

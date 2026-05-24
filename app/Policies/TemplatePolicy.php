<?php

namespace App\Policies;

use App\Models\Template;
use App\Models\User;

class TemplatePolicy
{
    public function view(User $user, Template $template): bool
    {
        return $template->business->user_id === $user->id;
    }

    public function update(User $user, Template $template): bool
    {
        return $template->business->user_id === $user->id;
    }

    public function delete(User $user, Template $template): bool
    {
        return $template->business->user_id === $user->id;
    }
}

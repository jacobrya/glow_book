<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Salon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        $specialist = $user->isSpecialist() ? $user->specialist : null;
        $salon = $user->isSalonOwner() ? Salon::where('owner_id', $user->id)->first() : null;

        return view('profile.edit', compact('user', 'specialist', 'salon'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. Заполняем основные данные
        $user->fill($request->validated());

        // 2. Логика загрузки аватара
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        // 3. Сбрасываем верификацию email, если он изменился
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // 4. Обновление данных специалиста
        if ($user->isSpecialist() && $user->specialist) {
            $user->specialist->update($request->only(['bio', 'experience_years']));
        }

        // 5. Обновление данных салона
        if ($user->isSalonOwner()) {
            $salon = Salon::where('owner_id', $user->id)->first();
            if ($salon) {
                $salon->update([
                    'name'        => $request->salon_name ?? $salon->name,
                    'address'     => $request->salon_address,
                    'city'        => $request->salon_city,
                    'phone'       => $request->salon_phone,
                    'description' => $request->salon_description,
                ]);
            }
        }

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return Redirect::route('profile.edit')->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class Increment1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(); // akaun demo: student1, admin1
    }

    // ---------- FR1: Log in ----------

    public function test_TC_I1_01_student_logs_in_and_goes_to_student_dashboard(): void
    {
        $this->post('/login', ['username' => 'student1', 'password' => 'Student@123'])
            ->assertRedirect(route('student.dashboard'));

        $this->assertAuthenticatedAs(User::where('username', 'student1')->first());
    }

    public function test_TC_I1_02_admin_logs_in_and_sees_admin_dashboard(): void
    {
        $this->followingRedirects()
            ->post('/login', ['username' => 'admin1', 'password' => 'Admin@123'])
            ->assertOk()
            ->assertSee('Administrator Dashboard');
    }

    public function test_TC_I1_03_wrong_password_is_rejected(): void
    {
        $this->from('/login')
            ->post('/login', ['username' => 'student1', 'password' => 'wrong-password'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors(['username' => 'Invalid username or password.']);

        $this->assertGuest();
    }

    public function test_TC_I1_04_unknown_username_is_rejected(): void
    {
        $this->from('/login')
            ->post('/login', ['username' => 'nobody', 'password' => 'Student@123'])
            ->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_TC_I1_05_empty_username_and_password_are_rejected(): void
    {
        $this->from('/login')
            ->post('/login', ['username' => '', 'password' => ''])
            ->assertSessionHasErrors(['username', 'password']);

        $this->assertGuest();
    }

    // ---------- FR1: Log out ----------

    public function test_TC_I1_06_logout_ends_the_session(): void
    {
        $this->post('/login', ['username' => 'student1', 'password' => 'Student@123']);
        $this->get('/student/dashboard')->assertOk();

        $this->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();

        $this->get('/student/dashboard')->assertRedirect(route('login'));
    }

    // ---------- Kawalan akses (BR4) ----------

    public function test_TC_I1_07_guest_is_redirected_to_login(): void
    {
        $this->get('/student/dashboard')->assertRedirect(route('login'));
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
    }

    public function test_TC_I1_08_student_cannot_open_admin_dashboard(): void
    {
        $student = User::where('username', 'student1')->first();

        $this->actingAs($student)->get('/admin/dashboard')->assertForbidden();
    }

    public function test_TC_I1_09_admin_cannot_open_student_dashboard(): void
    {
        $admin = User::where('username', 'admin1')->first();

        $this->actingAs($admin)->get('/student/dashboard')->assertForbidden();
    }

    public function test_TC_I1_10_logged_in_user_visiting_login_is_sent_to_dashboard(): void
    {
        $student = User::where('username', 'student1')->first();

        $this->actingAs($student)->get('/login')->assertRedirect(route('student.dashboard'));
    }

    // ---------- Pangkalan data dan keselamatan ----------

    public function test_TC_I1_11_passwords_are_stored_hashed(): void
    {
        $stored = User::where('username', 'student1')->first()->password;

        $this->assertNotEquals('Student@123', $stored);
        $this->assertTrue(Hash::check('Student@123', $stored));
    }

    public function test_TC_I1_12_database_rejects_invalid_role(): void
    {
        $this->expectException(QueryException::class);

        User::create([
            'name' => 'Bad Role',
            'username' => 'baduser',
            'email' => 'bad@example.com',
            'password' => 'Secret@123',
            'role' => 'superuser',
        ]);
    }

    public function test_TC_I1_13_login_form_escapes_html(): void
    {
        $this->followingRedirects()
            ->from('/login')
            ->post('/login', ['username' => '<script>alert(1)</script>', 'password' => 'x'])
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;', false);
    }
}
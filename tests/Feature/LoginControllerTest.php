<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Customer\LoginController;

class LoginControllerTest extends TestCase
{
    // use RefreshDatabase, WithFaker;

    /** @test */
    public function dangNhapThanhCong()
    {
        // Tạo một instance của Request và truyền vào dữ liệu giả mạo
        $request = new Request([
            'email' => 'test@gmail.com',
            'password' => 'Abcd1234',
        ]);

        // Tạo một instance của LoginController
        $loginController = new LoginController();

        // Gọi trực tiếp vào hàm postLogin với Request giả mạo
        $response = $loginController->postLogin($request);

        // Kiểm tra kết quả trả về
        $this->assertEquals(response()->json(['is' => 'login-success'])->content(), $response->content());
    }

    /** @test */
    public function emailTrong()
    {
        $request = new Request([
            'email' => '',
            'password' => 'Abcd1234',
        ]);
        $loginController = new LoginController();
        $response = $loginController->postLogin($request);
        $this->assertEquals(response()->json(['is' => 'login-failed', 'error' => ["Bạn chưa nhập email"]])->content(), $response->content());
    }

    /** @test */
    public function emailKhongHopLe()
    {
        $request = new Request([
            'email' => 'test',
            'password' => 'Abcd1234',
        ]);
        $loginController = new LoginController();
        $response = $loginController->postLogin($request);
        $this->assertEquals(response()->json(['is' => 'login-failed', 'error' => ["Email không hợp lệ"]])->content(), $response->content());
    }

    /** @test */
    public function emailChuaDangKy()
    {
        $request = new Request([
            'email' => 'test11@gmail.com',
            'password' => 'Abcd1234',
        ]);
        $loginController = new LoginController();
        $response = $loginController->postLogin($request);
        $this->assertEquals(response()->json(['is' => 'incorrect', 'incorrect' => 'Sai tài khoản hoặc mật khẩu!'])->content(), $response->content());
    }

    /** @test */
    public function matKhauTrong()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'password' => '',
        ]);
        $loginController = new LoginController();
        $response = $loginController->postLogin($request);
        $this->assertEquals(response()->json(['is' => 'login-failed', 'error' => ["Bạn chưa nhập mật khẩu"]])->content(), $response->content());
    }

    /** @test */
    public function matKhauSai()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'password' => 'Abcd12345',
        ]);
        $loginController = new LoginController();
        $response = $loginController->postLogin($request);
        $this->assertEquals(response()->json(['is' => 'incorrect', 'incorrect' => 'Sai tài khoản hoặc mật khẩu!'])->content(), $response->content());
    }
}

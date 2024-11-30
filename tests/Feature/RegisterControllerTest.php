<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\Customer\RegisterController;

class RegisterControllerTest extends TestCase
{
    // use RefreshDatabase, WithFaker;

    /** @test */
    public function dangKyThanhCong()
    {
        // Tạo một instance của Request và truyền vào dữ liệu giả mạo
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => 'Abcd1234',
            'address' => 'test',
        ]);

        // Tạo một instance của RegisterController
        $registerController = new RegisterController();

        // Gọi trực tiếp vào hàm register với Request giả mạo
        $response = $registerController->register($request);

        // Kiểm tra kết quả trả về
        $this->assertEquals(response()->json(['is' => 'login-success'])->content(), $response->content());
    }

    /** @test */
    public function emailTrong()
    {
        $request = new Request([
            'email' => '',
            'name' => 'test',
            'password' => 'Abcd1234',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Email không được để trống"]])->content(), $response->content());
    }   

    /** @test */
    public function emailKhongHopLe()
    {
        $request = new Request([
            'email' => 'test',
            'name' => 'test',
            'password' => 'Abcd1234',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Email không hợp lệ"]])->content(), $response->content());
    }  

    /** @test */
    public function emailDaDangKy()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => 'Abcd1234',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'unsuccess', 'uncomplete' => "Email đã đăng kí."])->content(), $response->content());
    } 

    /** @test */
    public function tenDNTrong()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => '',
            'password' => 'Abcd1234',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Tên đăng nhập không được để trống"]])->content(), $response->content());
    } 

    /** @test */
    public function tenDNKhongHopLe()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => 'test1234',
            'password' => 'Abcd1234',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Tên đăng nhập không hợp lệ"]])->content(), $response->content());
    } 

    /** @test */
    public function matKhauTrong()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => '',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Mật khẩu không được để trống"]])->content(), $response->content());
    } 

    /** @test */
    public function matKhauNhoHon8KyTu()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => 'Abcd123',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Mật khẩu tối thiểu 8 kí tự"]])->content(), $response->content());
    } 

    /** @test */
    public function matKhauLonHon16KyTu()
    {
        $request = new Request([
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => 'Abcd1234Abcd12345',
            'address' => 'test',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'failed', 'error' => ["Mật khẩu tối đa 16 kí tự"]])->content(), $response->content());
    } 

    /** @test */
    public function diaChiTrong()
    {
        $request = new Request([
            'email' => 'test1@gmail.com',
            'name' => 'test',
            'password' => 'Abcd1234',
            'address' => '',
        ]);
        $registerController = new RegisterController();
        $response = $registerController->register($request);
        $this->assertEquals(response()->json(['is' => 'login-success'])->content(), $response->content());
    } 
}

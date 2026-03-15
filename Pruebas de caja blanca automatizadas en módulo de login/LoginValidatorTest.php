<?php
// LoginValidatorTest.php
use PHPUnit\Framework\TestCase;

// Importamos la lógica que vamos a testear
require_once 'validador.php';

class LoginValidatorTest extends TestCase {
    private $mysqliMock;
    private $stmtMock;
    private $resultMock;
    private $validator;

    protected function setUp(): void {
        // Creamos los dobles (mocks) de las clases de PHP para bases de datos
        $this->mysqliMock = $this->createMock(mysqli::class);
        $this->stmtMock = $this->createMock(mysqli_stmt::class);
        $this->resultMock = $this->createMock(mysqli_result::class);

        // Configuramos el comportamiento del mock de la conexión
        $this->mysqliMock->method('prepare')->willReturn($this->stmtMock);
        $this->stmtMock->method('get_result')->willReturn($this->resultMock);

        // Instanciamos el validador pasando el mock
        $this->validator = new LoginValidator($this->mysqliMock);
    }

    public function testLoginSuccess() {
        $hashedPassword = password_hash('secreta123', PASSWORD_DEFAULT);
        
        $this->resultMock->method('fetch_assoc')->willReturn([
            'id' => 1,
            'password' => $hashedPassword
        ]);

        $result = $this->validator->validateLogin('usuario_real', 'secreta123');
        $this->assertEquals('success', $result);
    }

    public function testLoginInvalidPassword() {
        $hashedPassword = password_hash('secreta123', PASSWORD_DEFAULT);
        
        $this->resultMock->method('fetch_assoc')->willReturn([
            'id' => 1,
            'password' => $hashedPassword
        ]);

        $result = $this->validator->validateLogin('usuario_real', 'clave_incorrecta');
        $this->assertEquals('invalid_password', $result);
    }

    public function testLoginUserNotFound() {
        $this->resultMock->method('fetch_assoc')->willReturn(null);

        $result = $this->validator->validateLogin('usuario_no_existe', 'cualquier_clave');
        $this->assertEquals('user_not_found', $result);
    }
}
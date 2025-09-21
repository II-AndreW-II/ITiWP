<?php
require 'config.php';
require 'validation.php';

$errors = [];
$formData = [
    'title' => '',
    'description' => '',
    'phone' => '',
    'address' => '',
    'status' => 'не активен'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validation = validateContactData($_POST);
    
    if ($validation['isValid']) {
        $stmt = $pdo->prepare("INSERT INTO contacts (title, description, phone, address, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $validation['title'],
            $validation['description'],
            $validation['phone'],
            $validation['address'],
            $validation['status']
        ]);
        header('Location: index.php');
        exit;
    } else {
        $errors = $validation['errors'];
        $formData = [
            'title' => $validation['title'],
            'description' => $validation['description'],
            'phone' => $validation['phone'],
            'address' => $validation['address'],
            'status' => $validation['status']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить контакт</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #f4f4f4; 
        }
        
        h1 { 
            color: #333; 
            margin-bottom: 20px;
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        
        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: bold; 
            color: #333;
        }
        
        input, textarea, select { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #ddd; 
            border-radius: 5px; 
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        
        button { 
            background: #5cb85c; 
            color: white; 
            padding: 15px 25px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background: #4cae4c;
        }
        
        .alert { 
            color: #721c24; 
            background-color: #f8d7da; 
            border: 1px solid #f5c6cb; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 5px;
        }
        
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .required {
            color: red;
        }
        
        .field-hint {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .form-container {
                padding: 20px;
                margin: 0;
            }
            
            h1 {
                font-size: 24px;
            }
            
            input, textarea, select {
                font-size: 16px;
            }
        }
        
        @media (max-width: 480px) {
            .form-container {
                padding: 15px;
            }
            
            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Добавить контакт</h1>
        <?php displayErrors($errors); ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="title">Имя <span class="required">*</span>:</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($formData['title']) ?>" required maxlength="255">
                <div class="field-hint">Минимум 2 символа, только буквы, пробелы, дефисы и точки</div>
            </div>
            
            <div class="form-group">
                <label for="phone">Телефон <span class="required">*</span>:</label>
                <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($formData['phone']) ?>" required maxlength="255" placeholder="+375(29)123-45-67">
                <div class="field-hint">Формат: +375(29)123-45-67 или 8(029)123-45-67</div>
            </div>
            
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea name="description" id="description" rows="4" maxlength="1000" placeholder="Дополнительная информация о контакте..."><?= htmlspecialchars($formData['description']) ?></textarea>
                <div class="field-hint">Максимум 1000 символов</div>
            </div>
            
            <div class="form-group">
                <label for="address">Адрес:</label>
                <textarea name="address" id="address" rows="3" maxlength="500" placeholder="Полный адрес контакта..."><?= htmlspecialchars($formData['address']) ?></textarea>
                <div class="field-hint">Максимум 500 символов</div>
            </div>
            
            <div class="form-group">
                <label for="status">Статус:</label>
                <select name="status" id="status">
                    <option value="не активен" <?= $formData['status'] === 'не активен' ? 'selected' : '' ?>>Не активен</option>
                    <option value="активен" <?= $formData['status'] === 'активен' ? 'selected' : '' ?>>Активен</option>
                </select>
            </div>
            
            <button type="submit">Добавить контакт</button>
        </form>
    </div>
</body>
</html>

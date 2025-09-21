<?php
function validateTitle($title) {
    $title = trim($title);
    $errors = [];
    
    if (empty($title)) {
        $errors[] = "Имя обязательно для заполнения";
    } elseif (strlen($title) < 2) {
        $errors[] = "Имя должно содержать минимум 2 символа";
    } elseif (strlen($title) > 255) {
        $errors[] = "Имя не должно превышать 255 символов";
    } elseif (!preg_match('/^[а-яёА-ЯЁa-zA-Z\s\-\.]+$/u', $title)) {
        $errors[] = "Имя может содержать только буквы, пробелы, дефисы и точки";
    }
    
    return ['value' => $title, 'errors' => $errors];
}

function validateDescription($description) {
    $description = trim($description);
    $errors = [];
    
    if (!empty($description) && strlen($description) > 1000) {
        $errors[] = "Описание не должно превышать 1000 символов";
    }
    
    return ['value' => $description, 'errors' => $errors];
}

function validatePhone($phone) {
    $phone = trim($phone);
    $errors = [];
    
    if (empty($phone)) {
        $errors[] = "Номер телефона обязателен для заполнения";
    } else {
        $cleanPhone = preg_replace('/[^\d\+\-\(\)\s]/', '', $phone);
        
        if (!preg_match('/^[\+]?[0-9\s\-\(\)]{7,20}$/', $cleanPhone)) {
            $errors[] = "Неверный формат телефона. Используйте цифры, +, -, (, ), пробелы";
        } elseif (strlen(preg_replace('/[^\d]/', '', $cleanPhone)) < 7) {
            $errors[] = "Номер телефона должен содержать минимум 7 цифр";
        } elseif (strlen($phone) > 255) {
            $errors[] = "Номер телефона не должен превышать 255 символов";
        }
    }
    
    return ['value' => $phone, 'errors' => $errors];
}

function validateAddress($address) {
    $address = trim($address);
    $errors = [];
    
    if (!empty($address) && strlen($address) > 500) {
        $errors[] = "Адрес не должен превышать 500 символов";
    }
    
    return ['value' => $address, 'errors' => $errors];
}

function validateStatus($status) {
    $validStatuses = ['не активен', 'активен'];
    $errors = [];
    
    if (!in_array($status, $validStatuses)) {
        $errors[] = "Неверный статус";
    }
    
    return ['value' => $status, 'errors' => $errors];
}

function validateContactData($data) {
    $title = validateTitle($data['title'] ?? '');
    $description = validateDescription($data['description'] ?? '');
    $phone = validatePhone($data['phone'] ?? '');
    $address = validateAddress($data['address'] ?? '');
    $status = validateStatus($data['status'] ?? 'не активен');
    
    $allErrors = array_merge(
        $title['errors'],
        $description['errors'],
        $phone['errors'],
        $address['errors'],
        $status['errors']
    );
    
    return [
        'title' => $title['value'],
        'description' => $description['value'],
        'phone' => $phone['value'],
        'address' => $address['value'],
        'status' => $status['value'],
        'errors' => $allErrors,
        'isValid' => empty($allErrors)
    ];
}

function displayErrors($errors) {
    if (!empty($errors)) {
        echo '<div class="alert alert-danger">';
        echo '<ul style="margin: 0; padding-left: 20px;">';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
} 
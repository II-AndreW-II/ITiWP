<?php
require 'config.php';
require 'validation.php';

$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatDateTime($datetime) {
    if (empty($datetime)) return '';
    $date = new DateTime($datetime);
    return $date->format('d.m.Y H:i');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список контактов</title>
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
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            table-layout: fixed;
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: left; 
            vertical-align: top;
            word-wrap: break-word;
        }
        
        th { 
            background: #f8f9fa; 
            font-weight: bold; 
            color: #333;
        }

        th:nth-child(1), td:nth-child(1) { width: 5%; }  
        th:nth-child(2), td:nth-child(2) { width: 15%; } 
        th:nth-child(3), td:nth-child(3) { width: 20%; } 
        th:nth-child(4), td:nth-child(4) { width: 18%; } 
        th:nth-child(5), td:nth-child(5) { width: 17%; } 
        th:nth-child(6), td:nth-child(6) { width: 10%; } 
        th:nth-child(7), td:nth-child(7) { width: 10%; } 
        th:nth-child(8), td:nth-child(8) { width: 15%; } 
        
        .btn { 
            padding: 6px 8px; 
            text-decoration: none; 
            color: white; 
            border-radius: 3px; 
            margin: 2px;
            display: inline-block; 
            font-size: 12px;
            transition: all 0.3s;
            text-align: center;
            width: calc(100% - 4px);
            box-sizing: border-box;
        }
        
        .btn-edit { background: #f0ad4e; }
        .btn-delete { background: #d9534f; }
        .btn-status { background: #5bc0de; }
        
        .btn:hover { 
            opacity: 0.8; 
            transform: translateY(-1px);
        }
        
        .add-link { 
            display: inline-block; 
            margin: 10px 0; 
            background: #5cb85c; 
            padding: 12px 20px; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .add-link:hover { 
            background: #4cae4c;
        }
        
        .status-active { 
            color: #28a745; 
            font-weight: bold; 
        }
        
        .status-inactive { 
            color: #dc3545; 
            font-weight: bold; 
        }
        
        .no-contacts { 
            text-align: center; 
            color: #666; 
            padding: 40px; 
        }
        
        .actions { 
            padding: 8px !important;
        }
        
        .phone-cell {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .description-cell {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        @media (min-width: 770px) and (max-width: 1100px) {
            .phone-cell {
                white-space: normal;
                word-wrap: break-word;
                overflow-wrap: break-word;
                line-height: 1.3;
            }
            
            th:nth-child(4), td:nth-child(4) { width: 20%; }
            th:nth-child(5), td:nth-child(5) { width: 15%; }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 15px;
                margin: 0;
                overflow-x: auto;
            }
            
            table {
                font-size: 14px;
                min-width: 700px;
            }
            
            th, td {
                padding: 8px 6px;
            }
            

            th:nth-child(1), td:nth-child(1) { width: 6%; }  
            th:nth-child(2), td:nth-child(2) { width: 16%; } 
            th:nth-child(3), td:nth-child(3) { width: 14%; } 
            th:nth-child(4), td:nth-child(4) { width: 20%; }
            th:nth-child(5), td:nth-child(5) { width: 14%; } 
            th:nth-child(6), td:nth-child(6) { width: 10%; } 
            th:nth-child(7), td:nth-child(7) { width: 8%; }  
            th:nth-child(8), td:nth-child(8) { width: 12%; } 
            
            .btn {
                padding: 4px 6px;
                font-size: 10px;
                margin: 1px;
                width: calc(100% - 2px);
            }
            
            .actions {
                padding: 4px !important;
            }
            
            .phone-cell {
                min-width: 120px;
                white-space: normal;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            
            table {
                font-size: 12px;
                min-width: 600px;
            }
            
            th, td {
                padding: 6px 4px;
            }
            
         
            th:nth-child(1), td:nth-child(1) { width: 5%; }  
            th:nth-child(2), td:nth-child(2) { width: 18%; } 
            th:nth-child(3), td:nth-child(3) { width: 12%; } 
            th:nth-child(4), td:nth-child(4) { width: 22%; } 
            th:nth-child(5), td:nth-child(5) { width: 12%; } 
            th:nth-child(6), td:nth-child(6) { width: 8%; } 
            th:nth-child(7), td:nth-child(7) { width: 6%; } 
            th:nth-child(8), td:nth-child(8) { width: 17%; } 
            
            .btn {
                padding: 3px 4px;
                font-size: 9px;
                margin: 1px 0;
                width: 100%;
            }
            
            .actions {
                padding: 3px !important;
            }
            
            .phone-cell {
                min-width: 100px;
            }
        }
        
        @media (max-width: 360px) {
            table {
                min-width: 550px;
            }
            
            .btn {
                font-size: 8px;
                padding: 2px 3px;
            }
            
            .phone-cell {
                min-width: 90px;
            }
        }
        
        .table-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-container::-webkit-scrollbar {
            height: 8px;
        }
        
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .table-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Список контактов</h1>
        <a href="add.php" class="add-link">+ Добавить контакт</a>
        
        <?php if (empty($contacts)): ?>
            <div class="no-contacts">
                <p>Контакты не найдены. <a href="add.php">Добавить первый контакт</a></p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Описание</th>
                            <th>Телефон</th>
                            <th>Адрес</th>
                            <th>Статус</th>
                            <th>Создан</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?= htmlspecialchars($contact['id']) ?></td>
                            <td><?= htmlspecialchars($contact['title']) ?></td>
                            <td class="description-cell"><?= htmlspecialchars($contact['description'] ?? '') ?></td>
                            <td class="phone-cell"><?= htmlspecialchars($contact['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($contact['address'] ?? '') ?></td>
                            <td>
                                <span class="<?= $contact['status'] === 'активен' ? 'status-active' : 'status-inactive' ?>">
                                    <?= htmlspecialchars($contact['status']) ?>
                                </span>
                            </td>
                            <td><?= formatDateTime($contact['created_at']) ?></td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $contact['id'] ?>" class="btn btn-edit">Редактировать</a>
                                <a href="delete.php?id=<?= $contact['id'] ?>" class="btn btn-delete" onclick="return confirm('Удалить контакт?')">Удалить</a>
                                <a href="update_status.php?id=<?= $contact['id'] ?>&status=<?= $contact['status'] === 'активен' ? 'не активен' : 'активен' ?>" class="btn btn-status">
                                    <?= $contact['status'] === 'активен' ? 'Деактивировать' : 'Активировать' ?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
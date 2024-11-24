<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Miku Academy - Chat</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="Views/mensajeria.css">
  
</head>
<body class="bg-body-secondary">
<?php
if($_SESSION['user']['Rol']==='Alumno'){
require 'Components/headerStudent.php';
}else if($_SESSION['user']['Rol']==='Instructor'){
require 'Components/headerInstructor.php';
}
?>
  
 
  <div class="container row-12 d-flex justify-content-center bg-body-secondary">

    <div class="col-3 border rounded border-top-0">
      <nav class="navbar bg-body-tertiary border">
        <div class="container-fluid">
          <a class="navbar-brand" >
            <img src="https://cdn.icon-icons.com/icons2/2582/PNG/512/message_bubble_chat_icon_154003.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-center rounded-circle">           <b>CHAT</b>
          </a>
        </div>
      </nav>

      <!-- Lista de usuarios con los que se puede chatear -->
        <?php if (!empty($chatUsers)): ?>
            <?php foreach ($chatUsers as $chatUser): ?>
                <div class="row-12 message-div d-flex align-text-center pb-0" type="button" 
                     onclick="window.location.href='/BDM-CI/mensajeria?receiver_id=<?= htmlspecialchars($chatUser['ID_Usuario']) ?>'">
                    <p><?= htmlspecialchars($chatUser['Nombre'] . " " . $chatUser['Apellidos']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="row-12 message-div d-flex align-text-center pb-0">
                <p>No hay usuarios disponibles para chatear.</p>
            </div>
        <?php endif; ?>
    </div>


   <div class="col-10">
    <nav class="navbar bg-body-tertiary border">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="<?= htmlspecialchars($fotoSrcR) ?>" 
                     alt="ImgPerfil" width="40" height="40" class="d-inline-block align-text-center rounded-circle"> 
<b>Chat con <?= htmlspecialchars($receiverUser['Nombre'] . ' ' . $receiverUser['Apellidos']) ?></b>
        </a>            </a>
        </div>
    </nav>

<div class="chat-container">
    <div class="chat-container-messages" id="chat-container">
       <!-- Aquí se cargarán los mensajes dinámicamente -->
    </div>

    <!-- Zona de envío de mensajes -->

</div>
    <div class="row">
        <div class="container col-10 bg-body-secondary mt-2">
<form id="send-message-form" class="row bg-light-subtle rounded">
    <textarea name="message" id="message" class="hacer-mensaje rounded col-11" required></textarea>
    <input type="hidden" id="sender" name="id_emisor" value="<?= $id?>">
    <input type="hidden" id="receiver"name="id_receptor" value="<?= $id_receptor ?>">
    <button type="submit" class="btn col-1 d-flex justify-content-center align-items-center">
        <i class="bi bi-send fs-4 text"></i>
    </button>
</form>

           <br>
       </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function fetchMessages() {
    var sender = $('#sender').val();
    var receiver = $('#receiver').val();

    $.ajax({
        url: '/BDM-CI/fetchMessages',
        type: 'POST',
        data: {sender: sender, receiver: receiver},
        success: function(data) {
            console.log(data); // Verifica que se reciban los mensajes correctamente
            $('#chat-container').html(data);
            scrollChatToBottom(); // Desplaza hacia abajo automáticamente
        },
        error: function(err) {
            console.error('Error fetching messages:', err);
        }
    });
}


        // Function to scroll the chat box to the bottom
        function scrollChatToBottom() {
            var chatBox = $('#chat-container');
            chatBox.scrollTop(chatBox.prop("scrollHeight"));
        }

 
        
        $(document).ready(function() {
            // Fetch messages every 3 seconds
            
            fetchMessages();
            setInterval(fetchMessages, 3000);
        });

            // Submit the chat message
            $('#send-message-form').submit(function(e) {
            e.preventDefault();
            var sender = $('#sender').val();
            var receiver = $('#receiver').val();
            var message = $('#message').val();

            $.ajax({
                url: '/BDM-CI/sendMessage',
                type: 'POST',
                data: {sender: sender, receiver: receiver, message: message},
                success: function() {
                    console.log($('#message').val()); // Esto debería mostrar el mensaje enviado
$('#message').val(''); // Asegúrate de que el campo se vacíe
                    fetchMessages(); // Fetch messages after submitting
                }
            });

            });
</script>



</body>
</html>
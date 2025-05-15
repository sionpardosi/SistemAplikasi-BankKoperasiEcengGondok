<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Eceng Gondok</title>
    <style>
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        .chat-box {
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .message {
            margin: 10px 0;
            padding: 8px 12px;
            border-radius: 5px;
            max-width: 70%;
        }
        .user {
            background-color: #007bff;
            color: white;
            margin-left: auto;
            text-align: right;
        }
        .assistant {
            background-color: #28a745;
            color: white;
        }
        .input-area {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .input-area input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .input-area button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .input-area button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h2>Chatbot Eceng Gondok</h2>
        <div class="chat-box">
            @foreach ($messages as $message)
                <div class="message {{ $message->role }}">
                    {{ $message->content }}
                </div>
            @endforeach
        </div>
        <form action="{{ route('chat.send') }}" method="POST" class="input-area">
            @csrf
            @if($thread)
                <input type="hidden" name="thread_id" value="{{ $thread->id }}">
            @endif
            <input type="text" name="message" placeholder="Tanya tentang eceng gondok..." required>
            <button type="submit">Kirim</button>
        </form>
    </div>
</body>
</html>

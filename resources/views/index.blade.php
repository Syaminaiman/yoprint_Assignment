<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Try</title>
    <style>
        footer {
            text-align: center;
            background: #ccc;
            position: fixed;
            bottom: 0;
            height: 30px;
            width: 100%;
        }

        /* Style for the drag-and-drop area */
        #drag-drop-area {
            text-align: center;
            padding: 20px;
            border: 2px dashed #ccc;
            margin-bottom: 20px;
        }

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <!-- Drag-and-drop area -->
    <div id="drag-drop-area">
        <p></p>

        <!-- Form submission -->
        <form action="/YoPrint" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="file" style="width:100%;height:100%;" >
            <button type="submit" name="submit" style="float:left;">Submit</button>
        </form>
    </div>

    <!-- Upload logs table -->
    <table>
        <thead>
            <tr>
                <th style="width:20%">Time</th>
                <th>File Name</th>
                <th style="width:20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($uploadLogs as $log)
            <tr>
                <td>{{ $log->uploaded_at }}</td>
                <td>{{ $log->file_name }}</td>
                <td>{{ $log->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
<footer>Copyright 2023 Syamin Aiman</footer>

<script>
    const dragDropArea = document.getElementById('drag-drop-area');
    const fileInput = document.getElementById('file');



    // Handle file input when a file is dropped in the drag-drop area
    dragDropArea.addEventListener('dragover', function (e) {
        e.preventDefault();
        dragDropArea.classList.add('dragover');
    });

    dragDropArea.addEventListener('dragleave', function () {
        dragDropArea.classList.remove('dragover');
    });

    dragDropArea.addEventListener('drop', function (e) {
        e.preventDefault();
        dragDropArea.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            // Optionally, you can display the selected file name
            // document.getElementById('selected-file-name').textContent = files[0].name;
        }
    });

    // Optional: Display the selected file name (you can add an element with id="selected-file-name" in your HTML)
    fileInput.addEventListener('change', function () {
        document.getElementById('selected-file-name').textContent = fileInput.files[0].name;
    });
</script>

</html>

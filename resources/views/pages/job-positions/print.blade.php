<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #quotation {
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        tfoot td {
            font-weight: bold;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>

    <div id="quotation">
        <h1>List Job Position</h1>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Job Position</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobPositions as $jobPosition)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jobPosition->name }}</td>
                    <td>{{ $jobPosition->department->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
<table border="1">
    <thead>
        <tr>
            <th>#</th>
            <th>NPM</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Jenis Kelamin</th>
            <th>Angkatan</th>
            <th>Periode Pengisian</th>
            <th>Total SKS</th>
            <th>Sertifikat</th>
        </tr>
    </thead>
    <tbody>
        @if (count($students))
            @foreach ($students as $key => $student)
                <tr>
                    <td style="width: 25px;">{{ 1 + $key }}</td>
                    <td style="width: 95px;">{{ $student->npm }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $genders[$student->gender] }}</td>
                    <td>{{ $student->class_of }}</td>
                    <td>{{ date("d F Y", strtotime($student->period)) }}</td>
                    <td>{{ $student->sumsks }}</td>
                    <td>
                        @if($needed->value <= $student->sumsks)
                            @if($student->certificate_approve == 0)
                                Approved
                            @else
                                Not Approved
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">Data Not Found</td>
            </tr>
        @endif
    </tbody>
</table>
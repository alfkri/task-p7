<?php

namespace App\Http\Controllers;


use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Validator;

// import patient model
use App\Models\Patient;
// Import rule
use Illuminate\Validation\Rule;


class PatientController extends Controller
{
    // Method untuk menampilkan seluruh data pasien
    function index()
    {
        // Mengakses seluruh data dari database 
       $patients = Patient::all();

        // Kondisi jika data ditemukan maka akan mengembalikan seluruh data beserta kode 200
       if ($patients){
            $data = [
                'message' => "Get All Patient",
                'data' => $patients
            ];
            return response()->json($data,200);
        // Kondisi jika data tidak ditemukan maka akan mengembalikan pesan error beserta kode 404
        }else{
            $data = [
                'message' => "Empty Data"
            ];
            return response()->json($data,404);
        }
    }

    // Method untuk menginput data pasien ke database
    public function store(Request $request)
    {
        // Validasi input sesuai dengan ketentuan 
        $validasi = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'status' => ['required', Rule::in(['positive', 'Positive', 'recovered', 'Recovered', 'dead', 'Dead'])],
            'in_date_at' => "required",
            'out_date_at' => "nullable"              
        ]);        
        // Membuat data baru dan menyimpan di database
        $patients = Patient::create($validasi);

        $data = [
            'message' => 'Data Saved Succesfully',
            'data' => $patients,
        ];
        // Mengembalikan pesan berhasil beserta data yang di input dan kode 201
        return response()->json($data, 201);
    }

    // Method untuk menampilkan data berdasarkan id
    function show($id)
    {
        // Mencari data dari database sesuai dengan id yang diminta
        $patient = Patient::find($id);
        // Kondisi jika data ditemukan maka akan mengembalikan pesan berhasil beserta datanya dan kode 200
        if ($patient){
            $data = [
                'message' => 'Get Detail Patient',
                'data' => $patient
            ];
            return response()->json($data,200);
        // Kondisi jika data tidak ditemukan maka akan mengembalikan pesan error dan kode 404
        }else{
            $data = [
                'message' => "Data not found"
            ];
            return response()->json($data,404);
        }
    }

    // Method untuk memperbarui data berdasarkan id
    function update(Request $request, $id)
    {
        // Mencari data dari database sesuai dengan id yang diminta
        $patient = Patient::find($id);
        // Kondisi jika data pasien ditemukan maka akan menyimpan inputan yang diperbarui beserta pesan berhasil dan kode 200
        if ($patient){
            $patient->update($request->all());
            $data = [
                'message' => 'Data Updated Successfully',
                'data' => $patient
            ];
            return response()->json($data,200);   
        // Kondisis jika data pasien tidak ditemukan maka akan mengembalikan pesan error dan kode 404         
        } else{
            $data = [
                'message' => 'Data Not Found'
            ];
            return response()->json($data,404);
        }
    }

    // Method untuk menghapus data berdasarkan id
    function destroy($id)
    {
        // Mencari data dari database sesuai dengan id yang diminta
        $patient = Patient::find($id);
        // Kondisi jika data pasien ditemukan maka akan menghapus data yang diminta dan mengembalikan pesan berhasil dan kode 200
        if($patient){
            $patient->delete();
            $data = [
                'message' => 'Data Deleted Successfully'
            ];
            return response()->json($data,200);
        // Kondisi jika data tidak ditemukan maka akan mengembalikan pesan error dan kode 404
        } else{
            $data = [
                'message' => 'Data not found'
            ];
            return response()->json($data,404);
        }
    }

    // Method untuk mencari data berdasarkan nama
    function search($name)
    {
        // Mencari data dari database sesuai dengan nama yang diminta
        $patients = Patient::where('name', $name)->get();
        // Kondisi jika data ditemukan maka akan mengembalikan pesan berhasil beserta data yang diminta dan kode 200 
        if (count ($patients) > 0){
            $data = [
                'message' => 'Data Found Successfully',
                'data' => $patients
            ];
            return response()->json($data, 200);
        // Kondisi jika data tidak ditemukan maka akan mengembalikan pesan error dan kode 404
        }else {
            $data = [
                'message' => 'Data not Found'
            ];
            return response()->json($data, 404);
        }
    }

    // Method untuk mencari data berdasarkan status pasien
    public function search_by_status($status)
    {   
        // Mencari data dari database sesuai dengan status yang diminta dan mengurutkan nama berdasarkan abjad      
        $patients = patient::where('status', $status) 
                ->orderBy('name', 'asc')                  
                ->get();
        
        // Menghitung jumlah data pasien
        $total = count($patients);
        // Kondisi jika jumlah data lebih dari 0 maka akan mengembalikan pesan berhasil beserta total data dan seluruh data pasiennya
        if ($total > 0 ){
            $data = [
                'message' => 'Get All Patient By Status',
                'total' => $total,
                'data' => $patients ,
            ];
            return response()->json($data, 200);     
        // Kondisi jika data tidak ada maka akan mengembaikan pesan error dan kode 404 
        }else{
            $data = [
                'message' => 'Data not found',                
            ];
            return response()->json($data, 404);        
        }
    }
}

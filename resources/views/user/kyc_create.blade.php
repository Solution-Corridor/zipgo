<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    @include('user.includes.general_style')
    <title>KYC Verification</title>
</head>

<body class="min-h-screen bg-[#0A0A0F]">

    <div class="mx-auto max-w-[420px] min-h-screen bg-[#0A0A0F] shadow-2xl shadow-black/50 relative">

        @include('user.includes.top_greetings')

        <div class="px-4 pt-4 pb-28 space-y-5">

            <div class="text-center">
                <h1 class="text-xl font-bold text-white mb-1">Identity Verification</h1>
                <p class="text-gray-500 text-xs leading-tight">
                    Provide accurate info. All data is encrypted.
                </p>
            </div>

            @if (session('error'))
                <div class="bg-red-900/40 border border-red-700/50 text-red-200 px-4 py-3 rounded-xl text-center text-sm">
                    {{ session('error') }}
                </div>
            @endif

<form method="POST" action="{{ route('kyc.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                
                <!-- Personal Information -->
<div class="space-y-5 bg-gray-900/50 rounded-xl p-5 border border-gray-800">
    <h3 class="text-base font-semibold text-indigo-400 mb-3">Personal Details</h3>

    <!-- Full Name -->
    <div>
        <label for="full_name" class="block text-xs text-gray-400 mb-1.5">Full Name (as on ID)</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" placeholder="John Smith"
               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-indigo-600"
               required autocomplete="off">
        @error('full_name')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- City - Full Width -->
    <div>
        <label for="city" class="block text-xs text-gray-400 mb-1.5">City</label>
        <div class="relative" id="city-dropdown">
            <input type="text" id="city-search" 
                   class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-indigo-600"
                   placeholder="Search city..." autocomplete="off" required>

            <div id="city-list" 
                 class="hidden absolute z-50 w-full mt-1 bg-gray-800 border border-gray-700 rounded-lg shadow-2xl max-h-60 overflow-auto py-1 text-sm">
            </div>
        </div>

        <!-- Hidden Select with Complete List -->
        <select name="city" id="city" class="hidden" required>
 <option value="" {{ old('city') ? '' : 'selected' }}>Select City</option>

    <option value="Abbottabad" {{ old('city') == 'Abbottabad' ? 'selected' : '' }}>Abbottabad</option>
    <option value="Ahmedpur East" {{ old('city') == 'Ahmedpur East' ? 'selected' : '' }}>Ahmedpur East</option>
    <option value="Ali Pur" {{ old('city') == 'Ali Pur' ? 'selected' : '' }}>Ali Pur</option>
    <option value="Arifwala" {{ old('city') == 'Arifwala' ? 'selected' : '' }}>Arifwala</option>
    <option value="Attock" {{ old('city') == 'Attock' ? 'selected' : '' }}>Attock</option>
    <option value="Badin" {{ old('city') == 'Badin' ? 'selected' : '' }}>Badin</option>
    <option value="Bahawalnagar" {{ old('city') == 'Bahawalnagar' ? 'selected' : '' }}>Bahawalnagar</option>
    <option value="Bahawalpur" {{ old('city') == 'Bahawalpur' ? 'selected' : '' }}>Bahawalpur</option>
    <option value="Bannu" {{ old('city') == 'Bannu' ? 'selected' : '' }}>Bannu</option>
    <option value="Barki" {{ old('city') == 'Barki' ? 'selected' : '' }}>Barki</option>
    <option value="Batkhela" {{ old('city') == 'Batkhela' ? 'selected' : '' }}>Batkhela</option>
    <option value="Bhalwal" {{ old('city') == 'Bhalwal' ? 'selected' : '' }}>Bhalwal</option>
    <option value="Bhakkar" {{ old('city') == 'Bhakkar' ? 'selected' : '' }}>Bhakkar</option>
    <option value="Bhan Saeedabad" {{ old('city') == 'Bhan Saeedabad' ? 'selected' : '' }}>Bhan Saeedabad</option>
    <option value="Bhera" {{ old('city') == 'Bhera' ? 'selected' : '' }}>Bhera</option>
    <option value="Bhit Shah" {{ old('city') == 'Bhit Shah' ? 'selected' : '' }}>Bhit Shah</option>
    <option value="Burewala" {{ old('city') == 'Burewala' ? 'selected' : '' }}>Burewala</option>
    <option value="Chak Jhumra" {{ old('city') == 'Chak Jhumra' ? 'selected' : '' }}>Chak Jhumra</option>
    <option value="Chakwal" {{ old('city') == 'Chakwal' ? 'selected' : '' }}>Chakwal</option>
    <option value="Charsadda" {{ old('city') == 'Charsadda' ? 'selected' : '' }}>Charsadda</option>
    <option value="Chawinda" {{ old('city') == 'Chawinda' ? 'selected' : '' }}>Chawinda</option>
    <option value="Chichawatni" {{ old('city') == 'Chichawatni' ? 'selected' : '' }}>Chichawatni</option>
    <option value="Chiniot" {{ old('city') == 'Chiniot' ? 'selected' : '' }}>Chiniot</option>
    <option value="Chishtian" {{ old('city') == 'Chishtian' ? 'selected' : '' }}>Chishtian</option>
    <option value="Chitral" {{ old('city') == 'Chitral' ? 'selected' : '' }}>Chitral</option>
    <option value="Choa Saidan Shah" {{ old('city') == 'Choa Saidan Shah' ? 'selected' : '' }}>Choa Saidan Shah</option>
    <option value="Dadu" {{ old('city') == 'Dadu' ? 'selected' : '' }}>Dadu</option>
    <option value="Daharki" {{ old('city') == 'Daharki' ? 'selected' : '' }}>Daharki</option>
    <option value="Darya Khan" {{ old('city') == 'Darya Khan' ? 'selected' : '' }}>Darya Khan</option>
    <option value="Daska" {{ old('city') == 'Daska' ? 'selected' : '' }}>Daska</option>
    <option value="Dera Allah Yar" {{ old('city') == 'Dera Allah Yar' ? 'selected' : '' }}>Dera Allah Yar</option>
    <option value="Dera Ghazi Khan" {{ old('city') == 'Dera Ghazi Khan' ? 'selected' : '' }}>Dera Ghazi Khan</option>
    <option value="Dera Ismail Khan" {{ old('city') == 'Dera Ismail Khan' ? 'selected' : '' }}>Dera Ismail Khan</option>
    <option value="Dera Murad Jamali" {{ old('city') == 'Dera Murad Jamali' ? 'selected' : '' }}>Dera Murad Jamali</option>
    <option value="Dhanote" {{ old('city') == 'Dhanote' ? 'selected' : '' }}>Dhanote</option>
    <option value="Digri" {{ old('city') == 'Digri' ? 'selected' : '' }}>Digri</option>
    <option value="Dijkot" {{ old('city') == 'Dijkot' ? 'selected' : '' }}>Dijkot</option>
    <option value="Dina" {{ old('city') == 'Dina' ? 'selected' : '' }}>Dina</option>
    <option value="Dinga" {{ old('city') == 'Dinga' ? 'selected' : '' }}>Dinga</option>
    <option value="Dipalpur" {{ old('city') == 'Dipalpur' ? 'selected' : '' }}>Dipalpur</option>
    <option value="Dokri" {{ old('city') == 'Dokri' ? 'selected' : '' }}>Dokri</option>
    <option value="Dunyapur" {{ old('city') == 'Dunyapur' ? 'selected' : '' }}>Dunyapur</option>
    <option value="Eminabad" {{ old('city') == 'Eminabad' ? 'selected' : '' }}>Eminabad</option>
    <option value="Faisalabad" {{ old('city') == 'Faisalabad' ? 'selected' : '' }}>Faisalabad</option>
    <option value="Farooqabad" {{ old('city') == 'Farooqabad' ? 'selected' : '' }}>Farooqabad</option>
    <option value="Fateh Jang" {{ old('city') == 'Fateh Jang' ? 'selected' : '' }}>Fateh Jang</option>
    <option value="Fatehpur" {{ old('city') == 'Fatehpur' ? 'selected' : '' }}>Fatehpur</option>
    <option value="Ferozewala" {{ old('city') == 'Ferozewala' ? 'selected' : '' }}>Ferozewala</option>
    <option value="Fort Abbas" {{ old('city') == 'Fort Abbas' ? 'selected' : '' }}>Fort Abbas</option>
    <option value="Gambat" {{ old('city') == 'Gambat' ? 'selected' : '' }}>Gambat</option>
    <option value="Garh Maharaja" {{ old('city') == 'Garh Maharaja' ? 'selected' : '' }}>Garh Maharaja</option>
    <option value="Garhi Khairo" {{ old('city') == 'Garhi Khairo' ? 'selected' : '' }}>Garhi Khairo</option>
    <option value="Ghakar" {{ old('city') == 'Ghakar' ? 'selected' : '' }}>Ghakar</option>
    <option value="Ghakhar Mandi" {{ old('city') == 'Ghakhar Mandi' ? 'selected' : '' }}>Ghakhar Mandi</option>
    <option value="Gharo" {{ old('city') == 'Gharo' ? 'selected' : '' }}>Gharo</option>
    <option value="Ghotki" {{ old('city') == 'Ghotki' ? 'selected' : '' }}>Ghotki</option>
    <option value="Gilgit" {{ old('city') == 'Gilgit' ? 'selected' : '' }}>Gilgit</option>
    <option value="Gojra" {{ old('city') == 'Gojra' ? 'selected' : '' }}>Gojra</option>
    <option value="Gujranwala" {{ old('city') == 'Gujranwala' ? 'selected' : '' }}>Gujranwala</option>
    <option value="Gujrat" {{ old('city') == 'Gujrat' ? 'selected' : '' }}>Gujrat</option>
    <option value="Gwadar" {{ old('city') == 'Gwadar' ? 'selected' : '' }}>Gwadar</option>
    <option value="Hafizabad" {{ old('city') == 'Hafizabad' ? 'selected' : '' }}>Hafizabad</option>
    <option value="Hala" {{ old('city') == 'Hala' ? 'selected' : '' }}>Hala</option>
    <option value="Harappa" {{ old('city') == 'Harappa' ? 'selected' : '' }}>Harappa</option>
    <option value="Haripur" {{ old('city') == 'Haripur' ? 'selected' : '' }}>Haripur</option>
    <option value="Hasilpur" {{ old('city') == 'Hasilpur' ? 'selected' : '' }}>Hasilpur</option>
    <option value="Hassan Abdal" {{ old('city') == 'Hassan Abdal' ? 'selected' : '' }}>Hassan Abdal</option>
    <option value="Havelian" {{ old('city') == 'Havelian' ? 'selected' : '' }}>Havelian</option>
    <option value="Hazro" {{ old('city') == 'Hazro' ? 'selected' : '' }}>Hazro</option>
    <option value="Hub" {{ old('city') == 'Hub' ? 'selected' : '' }}>Hub</option>
    <option value="Hyderabad" {{ old('city') == 'Hyderabad' ? 'selected' : '' }}>Hyderabad</option>
    <option value="Islamabad" {{ old('city') == 'Islamabad' ? 'selected' : '' }}>Islamabad</option>
    <option value="Jacobabad" {{ old('city') == 'Jacobabad' ? 'selected' : '' }}>Jacobabad</option>
    <option value="Jahanian" {{ old('city') == 'Jahanian' ? 'selected' : '' }}>Jahanian</option>
    <option value="Jalalpur Jattan" {{ old('city') == 'Jalalpur Jattan' ? 'selected' : '' }}>Jalalpur Jattan</option>
    <option value="Jalalpur Pirwala" {{ old('city') == 'Jalalpur Pirwala' ? 'selected' : '' }}>Jalalpur Pirwala</option>
    <option value="Jampur" {{ old('city') == 'Jampur' ? 'selected' : '' }}>Jampur</option>
    <option value="Jamshoro" {{ old('city') == 'Jamshoro' ? 'selected' : '' }}>Jamshoro</option>
    <option value="Jaranwala" {{ old('city') == 'Jaranwala' ? 'selected' : '' }}>Jaranwala</option>
    <option value="Jatoi" {{ old('city') == 'Jatoi' ? 'selected' : '' }}>Jatoi</option>
    <option value="Jauharabad" {{ old('city') == 'Jauharabad' ? 'selected' : '' }}>Jauharabad</option>
    <option value="Jhang" {{ old('city') == 'Jhang' ? 'selected' : '' }}>Jhang</option>
    <option value="Jhelum" {{ old('city') == 'Jhelum' ? 'selected' : '' }}>Jhelum</option>
    <option value="Jhol" {{ old('city') == 'Jhol' ? 'selected' : '' }}>Jhol</option>
    <option value="Kabul River" {{ old('city') == 'Kabul River' ? 'selected' : '' }}>Kabul River</option>
    <option value="Kahan" {{ old('city') == 'Kahan' ? 'selected' : '' }}>Kahan</option>
    <option value="Kahror Pakka" {{ old('city') == 'Kahror Pakka' ? 'selected' : '' }}>Kahror Pakka</option>
    <option value="Kahuta" {{ old('city') == 'Kahuta' ? 'selected' : '' }}>Kahuta</option>
    <option value="Kakul" {{ old('city') == 'Kakul' ? 'selected' : '' }}>Kakul</option>
    <option value="Kalabagh" {{ old('city') == 'Kalabagh' ? 'selected' : '' }}>Kalabagh</option>
    <option value="Kalat" {{ old('city') == 'Kalat' ? 'selected' : '' }}>Kalat</option>
    <option value="Kaleke Mandi" {{ old('city') == 'Kaleke Mandi' ? 'selected' : '' }}>Kaleke Mandi</option>
    <option value="Kallar Kahar" {{ old('city') == 'Kallar Kahar' ? 'selected' : '' }}>Kallar Kahar</option>
    <option value="Kalur Kot" {{ old('city') == 'Kalur Kot' ? 'selected' : '' }}>Kalur Kot</option>
    <option value="Kamber Ali Khan" {{ old('city') == 'Kamber Ali Khan' ? 'selected' : '' }}>Kamber Ali Khan</option>
    <option value="Kamoke" {{ old('city') == 'Kamoke' ? 'selected' : '' }}>Kamoke</option>
    <option value="Kamra" {{ old('city') == 'Kamra' ? 'selected' : '' }}>Kamra</option>
    <option value="Kandhkot" {{ old('city') == 'Kandhkot' ? 'selected' : '' }}>Kandhkot</option>
    <option value="Kandiaro" {{ old('city') == 'Kandiaro' ? 'selected' : '' }}>Kandiaro</option>
    <option value="Karachi" {{ old('city') == 'Karachi' ? 'selected' : '' }}>Karachi</option>
    <option value="Karak" {{ old('city') == 'Karak' ? 'selected' : '' }}>Karak</option>
    <option value="Karor Lal Esan" {{ old('city') == 'Karor Lal Esan' ? 'selected' : '' }}>Karor Lal Esan</option>
    <option value="Kashmore" {{ old('city') == 'Kashmore' ? 'selected' : '' }}>Kashmore</option>
    <option value="Kasur" {{ old('city') == 'Kasur' ? 'selected' : '' }}>Kasur</option>
    <option value="Kazi Ahmed" {{ old('city') == 'Kazi Ahmed' ? 'selected' : '' }}>Kazi Ahmed</option>
    <option value="Khairpur" {{ old('city') == 'Khairpur' ? 'selected' : '' }}>Khairpur</option>
    <option value="Khairpur Tamewali" {{ old('city') == 'Khairpur Tamewali' ? 'selected' : '' }}>Khairpur Tamewali</option>
    <option value="Khan Bela" {{ old('city') == 'Khan Bela' ? 'selected' : '' }}>Khan Bela</option>
    <option value="Khanewal" {{ old('city') == 'Khanewal' ? 'selected' : '' }}>Khanewal</option>
    <option value="Khanpur" {{ old('city') == 'Khanpur' ? 'selected' : '' }}>Khanpur</option>
    <option value="Khar" {{ old('city') == 'Khar' ? 'selected' : '' }}>Khar</option>
    <option value="Kharak" {{ old('city') == 'Kharak' ? 'selected' : '' }}>Kharak</option>
    <option value="Kharan" {{ old('city') == 'Kharan' ? 'selected' : '' }}>Kharan</option>
    <option value="Khewra" {{ old('city') == 'Khewra' ? 'selected' : '' }}>Khewra</option>
    <option value="Khurrianwala" {{ old('city') == 'Khurrianwala' ? 'selected' : '' }}>Khurrianwala</option>
    <option value="Khushab" {{ old('city') == 'Khushab' ? 'selected' : '' }}>Khushab</option>
    <option value="Khuzdar" {{ old('city') == 'Khuzdar' ? 'selected' : '' }}>Khuzdar</option>
    <option value="Kot Abdul Malik" {{ old('city') == 'Kot Abdul Malik' ? 'selected' : '' }}>Kot Abdul Malik</option>
    <option value="Kot Addu" {{ old('city') == 'Kot Addu' ? 'selected' : '' }}>Kot Addu</option>
    <option value="Kot Mithan" {{ old('city') == 'Kot Mithan' ? 'selected' : '' }}>Kot Mithan</option>
    <option value="Kot Radha Kishan" {{ old('city') == 'Kot Radha Kishan' ? 'selected' : '' }}>Kot Radha Kishan</option>
    <option value="Kot Samaba" {{ old('city') == 'Kot Samaba' ? 'selected' : '' }}>Kot Samaba</option>
    <option value="Kotli" {{ old('city') == 'Kotli' ? 'selected' : '' }}>Kotli</option>
    <option value="Kotri" {{ old('city') == 'Kotri' ? 'selected' : '' }}>Kotri</option>
    <option value="Kunri" {{ old('city') == 'Kunri' ? 'selected' : '' }}>Kunri</option>
    <option value="Lahore" {{ old('city') == 'Lahore' ? 'selected' : '' }}>Lahore</option>
    <option value="Lala Musa" {{ old('city') == 'Lala Musa' ? 'selected' : '' }}>Lala Musa</option>
    <option value="Lalian" {{ old('city') == 'Lalian' ? 'selected' : '' }}>Lalian</option>
    <option value="Landi Kotal" {{ old('city') == 'Landi Kotal' ? 'selected' : '' }}>Landi Kotal</option>
    <option value="Larkana" {{ old('city') == 'Larkana' ? 'selected' : '' }}>Larkana</option>
    <option value="Layyah" {{ old('city') == 'Layyah' ? 'selected' : '' }}>Layyah</option>
    <option value="Liaquatpur" {{ old('city') == 'Liaquatpur' ? 'selected' : '' }}>Liaquatpur</option>
    <option value="Lodhran" {{ old('city') == 'Lodhran' ? 'selected' : '' }}>Lodhran</option>
    <option value="Mailsi" {{ old('city') == 'Mailsi' ? 'selected' : '' }}>Mailsi</option>
    <option value="Malakwal" {{ old('city') == 'Malakwal' ? 'selected' : '' }}>Malakwal</option>
    <option value="Mandra" {{ old('city') == 'Mandra' ? 'selected' : '' }}>Mandra</option>
    <option value="Mandi Bahauddin" {{ old('city') == 'Mandi Bahauddin' ? 'selected' : '' }}>Mandi Bahauddin</option>
    <option value="Mangla" {{ old('city') == 'Mangla' ? 'selected' : '' }}>Mangla</option>
    <option value="Mankera" {{ old('city') == 'Mankera' ? 'selected' : '' }}>Mankera</option>
    <option value="Mansehra" {{ old('city') == 'Mansehra' ? 'selected' : '' }}>Mansehra</option>
    <option value="Mardan" {{ old('city') == 'Mardan' ? 'selected' : '' }}>Mardan</option>
    <option value="Mastung" {{ old('city') == 'Mastung' ? 'selected' : '' }}>Mastung</option>
    <option value="Matli" {{ old('city') == 'Matli' ? 'selected' : '' }}>Matli</option>
    <option value="Mehar" {{ old('city') == 'Mehar' ? 'selected' : '' }}>Mehar</option>
    <option value="Mian Channun" {{ old('city') == 'Mian Channun' ? 'selected' : '' }}>Mian Channun</option>
    <option value="Mianwali" {{ old('city') == 'Mianwali' ? 'selected' : '' }}>Mianwali</option>
    <option value="Mingora" {{ old('city') == 'Mingora' ? 'selected' : '' }}>Mingora</option>
    <option value="Mirpur (AJK)" {{ old('city') == 'Mirpur (AJK)' ? 'selected' : '' }}>Mirpur (AJK)</option>
    <option value="Mirpur Bathoro" {{ old('city') == 'Mirpur Bathoro' ? 'selected' : '' }}>Mirpur Bathoro</option>
    <option value="Mirpur Khas" {{ old('city') == 'Mirpur Khas' ? 'selected' : '' }}>Mirpur Khas</option>
    <option value="Mirpur Mathelo" {{ old('city') == 'Mirpur Mathelo' ? 'selected' : '' }}>Mirpur Mathelo</option>
    <option value="Mithi" {{ old('city') == 'Mithi' ? 'selected' : '' }}>Mithi</option>
    <option value="Moro" {{ old('city') == 'Moro' ? 'selected' : '' }}>Moro</option>
    <option value="Multan" {{ old('city') == 'Multan' ? 'selected' : '' }}>Multan</option>
    <option value="Muridke" {{ old('city') == 'Muridke' ? 'selected' : '' }}>Muridke</option>
    <option value="Murree" {{ old('city') == 'Murree' ? 'selected' : '' }}>Murree</option>
    <option value="Musafir Khana" {{ old('city') == 'Musafir Khana' ? 'selected' : '' }}>Musafir Khana</option>
    <option value="Muzaffarabad" {{ old('city') == 'Muzaffarabad' ? 'selected' : '' }}>Muzaffarabad</option>
    <option value="Muzaffargarh" {{ old('city') == 'Muzaffargarh' ? 'selected' : '' }}>Muzaffargarh</option>
    <option value="Nankana Sahib" {{ old('city') == 'Nankana Sahib' ? 'selected' : '' }}>Nankana Sahib</option>
    <option value="Narang Mandi" {{ old('city') == 'Narang Mandi' ? 'selected' : '' }}>Narang Mandi</option>
    <option value="Narowal" {{ old('city') == 'Narowal' ? 'selected' : '' }}>Narowal</option>
    <option value="Nasirabad" {{ old('city') == 'Nasirabad' ? 'selected' : '' }}>Nasirabad</option>
    <option value="Naudero" {{ old('city') == 'Naudero' ? 'selected' : '' }}>Naudero</option>
    <option value="Naukot" {{ old('city') == 'Naukot' ? 'selected' : '' }}>Naukot</option>
    <option value="Naushahro Feroze" {{ old('city') == 'Naushahro Feroze' ? 'selected' : '' }}>Naushahro Feroze</option>
    <option value="Nawabshah" {{ old('city') == 'Nawabshah' ? 'selected' : '' }}>Nawabshah</option>
    <option value="Nazimabad" {{ old('city') == 'Nazimabad' ? 'selected' : '' }}>Nazimabad</option>
    <option value="New Mirpur" {{ old('city') == 'New Mirpur' ? 'selected' : '' }}>New Mirpur</option>
    <option value="Nooriabad" {{ old('city') == 'Nooriabad' ? 'selected' : '' }}>Nooriabad</option>
    <option value="Nowshera" {{ old('city') == 'Nowshera' ? 'selected' : '' }}>Nowshera</option>
    <option value="Nowshera Virkan" {{ old('city') == 'Nowshera Virkan' ? 'selected' : '' }}>Nowshera Virkan</option>
    <option value="Okara" {{ old('city') == 'Okara' ? 'selected' : '' }}>Okara</option>
    <option value="Pakpattan" {{ old('city') == 'Pakpattan' ? 'selected' : '' }}>Pakpattan</option>
    <option value="Panjgur" {{ old('city') == 'Panjgur' ? 'selected' : '' }}>Panjgur</option>
    <option value="Pano Aqil" {{ old('city') == 'Pano Aqil' ? 'selected' : '' }}>Pano Aqil</option>
    <option value="Pasni" {{ old('city') == 'Pasni' ? 'selected' : '' }}>Pasni</option>
    <option value="Pasrur" {{ old('city') == 'Pasrur' ? 'selected' : '' }}>Pasrur</option>
    <option value="Pattoki" {{ old('city') == 'Pattoki' ? 'selected' : '' }}>Pattoki</option>
    <option value="Peshawar" {{ old('city') == 'Peshawar' ? 'selected' : '' }}>Peshawar</option>
    <option value="Phalia" {{ old('city') == 'Phalia' ? 'selected' : '' }}>Phalia</option>
    <option value="Pind Dadan Khan" {{ old('city') == 'Pind Dadan Khan' ? 'selected' : '' }}>Pind Dadan Khan</option>
    <option value="Pindi Bhattian" {{ old('city') == 'Pindi Bhattian' ? 'selected' : '' }}>Pindi Bhattian</option>
    <option value="Pindi Gheb" {{ old('city') == 'Pindi Gheb' ? 'selected' : '' }}>Pindi Gheb</option>
    <option value="Pir Mahal" {{ old('city') == 'Pir Mahal' ? 'selected' : '' }}>Pir Mahal</option>
    <option value="Qadirpur Ran" {{ old('city') == 'Qadirpur Ran' ? 'selected' : '' }}>Qadirpur Ran</option>
    <option value="Qambar" {{ old('city') == 'Qambar' ? 'selected' : '' }}>Qambar</option>
    <option value="Qila Didar Singh" {{ old('city') == 'Qila Didar Singh' ? 'selected' : '' }}>Qila Didar Singh</option>
    <option value="Qila Sobha Singh" {{ old('city') == 'Qila Sobha Singh' ? 'selected' : '' }}>Qila Sobha Singh</option>
    <option value="Quetta" {{ old('city') == 'Quetta' ? 'selected' : '' }}>Quetta</option>
    <option value="Rahim Yar Khan" {{ old('city') == 'Rahim Yar Khan' ? 'selected' : '' }}>Rahim Yar Khan</option>
    <option value="Raiwind" {{ old('city') == 'Raiwind' ? 'selected' : '' }}>Raiwind</option>
    <option value="Raja Jang" {{ old('city') == 'Raja Jang' ? 'selected' : '' }}>Raja Jang</option>
    <option value="Rajanpur" {{ old('city') == 'Rajanpur' ? 'selected' : '' }}>Rajanpur</option>
    <option value="Rasool" {{ old('city') == 'Rasool' ? 'selected' : '' }}>Rasool</option>
    <option value="Ratodero" {{ old('city') == 'Ratodero' ? 'selected' : '' }}>Ratodero</option>
    <option value="Rawalakot" {{ old('city') == 'Rawalakot' ? 'selected' : '' }}>Rawalakot</option>
    <option value="Rawalpindi" {{ old('city') == 'Rawalpindi' ? 'selected' : '' }}>Rawalpindi</option>
    <option value="Renala Khurd" {{ old('city') == 'Renala Khurd' ? 'selected' : '' }}>Renala Khurd</option>
    <option value="Risalpur" {{ old('city') == 'Risalpur' ? 'selected' : '' }}>Risalpur</option>
    <option value="Rohri" {{ old('city') == 'Rohri' ? 'selected' : '' }}>Rohri</option>
    <option value="Sadiqabad" {{ old('city') == 'Sadiqabad' ? 'selected' : '' }}>Sadiqabad</option>
    <option value="Sahiwal" {{ old('city') == 'Sahiwal' ? 'selected' : '' }}>Sahiwal</option>
    <option value="Saidu Sharif" {{ old('city') == 'Saidu Sharif' ? 'selected' : '' }}>Saidu Sharif</option>
    <option value="Sakrand" {{ old('city') == 'Sakrand' ? 'selected' : '' }}>Sakrand</option>
    <option value="Samundri" {{ old('city') == 'Samundri' ? 'selected' : '' }}>Samundri</option>
    <option value="Sanghar" {{ old('city') == 'Sanghar' ? 'selected' : '' }}>Sanghar</option>
    <option value="Sangla Hill" {{ old('city') == 'Sangla Hill' ? 'selected' : '' }}>Sangla Hill</option>
    <option value="Sanjwal" {{ old('city') == 'Sanjwal' ? 'selected' : '' }}>Sanjwal</option>
    <option value="Sara-e-Naurang" {{ old('city') == 'Sara-e-Naurang' ? 'selected' : '' }}>Sara-e-Naurang</option>
    <option value="Sarai Alamgir" {{ old('city') == 'Sarai Alamgir' ? 'selected' : '' }}>Sarai Alamgir</option>
    <option value="Sargodha" {{ old('city') == 'Sargodha' ? 'selected' : '' }}>Sargodha</option>
    <option value="Shahdadkot" {{ old('city') == 'Shahdadkot' ? 'selected' : '' }}>Shahdadkot</option>
    <option value="Shahdadpur" {{ old('city') == 'Shahdadpur' ? 'selected' : '' }}>Shahdadpur</option>
    <option value="Shahpur Chakar" {{ old('city') == 'Shahpur Chakar' ? 'selected' : '' }}>Shahpur Chakar</option>
    <option value="Shakargarh" {{ old('city') == 'Shakargarh' ? 'selected' : '' }}>Shakargarh</option>
    <option value="Shamsabad" {{ old('city') == 'Shamsabad' ? 'selected' : '' }}>Shamsabad</option>
    <option value="Sheikhupura" {{ old('city') == 'Sheikhupura' ? 'selected' : '' }}>Sheikhupura</option>
    <option value="Shikarpur" {{ old('city') == 'Shikarpur' ? 'selected' : '' }}>Shikarpur</option>
    <option value="Shorkot" {{ old('city') == 'Shorkot' ? 'selected' : '' }}>Shorkot</option>
    <option value="Sialkot" {{ old('city') == 'Sialkot' ? 'selected' : '' }}>Sialkot</option>
    <option value="Sibi" {{ old('city') == 'Sibi' ? 'selected' : '' }}>Sibi</option>
    <option value="Sihala" {{ old('city') == 'Sihala' ? 'selected' : '' }}>Sihala</option>
    <option value="Sillanwali" {{ old('city') == 'Sillanwali' ? 'selected' : '' }}>Sillanwali</option>
    <option value="Skardu" {{ old('city') == 'Skardu' ? 'selected' : '' }}>Skardu</option>
    <option value="Sohawa" {{ old('city') == 'Sohawa' ? 'selected' : '' }}>Sohawa</option>
    <option value="Sukkur" {{ old('city') == 'Sukkur' ? 'selected' : '' }}>Sukkur</option>
    <option value="Swabi" {{ old('city') == 'Swabi' ? 'selected' : '' }}>Swabi</option>
    <option value="Swat" {{ old('city') == 'Swat' ? 'selected' : '' }}>Swat</option>
    <option value="Talagang" {{ old('city') == 'Talagang' ? 'selected' : '' }}>Talagang</option>
    <option value="Talhar" {{ old('city') == 'Talhar' ? 'selected' : '' }}>Talhar</option>
    <option value="Tando Adam" {{ old('city') == 'Tando Adam' ? 'selected' : '' }}>Tando Adam</option>
    <option value="Tando Allahyar" {{ old('city') == 'Tando Allahyar' ? 'selected' : '' }}>Tando Allahyar</option>
    <option value="Tando Muhammad Khan" {{ old('city') == 'Tando Muhammad Khan' ? 'selected' : '' }}>Tando Muhammad Khan</option>
    <option value="Tangwani" {{ old('city') == 'Tangwani' ? 'selected' : '' }}>Tangwani</option>
    <option value="Tank" {{ old('city') == 'Tank' ? 'selected' : '' }}>Tank</option>
    <option value="Tarbela" {{ old('city') == 'Tarbela' ? 'selected' : '' }}>Tarbela</option>
    <option value="Tarnol" {{ old('city') == 'Tarnol' ? 'selected' : '' }}>Tarnol</option>
    <option value="Taxila" {{ old('city') == 'Taxila' ? 'selected' : '' }}>Taxila</option>
    <option value="Tharparkar" {{ old('city') == 'Tharparkar' ? 'selected' : '' }}>Tharparkar</option>
    <option value="Thatta" {{ old('city') == 'Thatta' ? 'selected' : '' }}>Thatta</option>
    <option value="Timergara" {{ old('city') == 'Timergara' ? 'selected' : '' }}>Timergara</option>
    <option value="Toba Tek Singh" {{ old('city') == 'Toba Tek Singh' ? 'selected' : '' }}>Toba Tek Singh</option>
    <option value="Topi" {{ old('city') == 'Topi' ? 'selected' : '' }}>Topi</option>
    <option value="Turbat" {{ old('city') == 'Turbat' ? 'selected' : '' }}>Turbat</option>
    <option value="Ubauro" {{ old('city') == 'Ubauro' ? 'selected' : '' }}>Ubauro</option>
    <option value="Uch" {{ old('city') == 'Uch' ? 'selected' : '' }}>Uch</option>
    <option value="Umerkot" {{ old('city') == 'Umerkot' ? 'selected' : '' }}>Umerkot</option>
    <option value="Utmanzai" {{ old('city') == 'Utmanzai' ? 'selected' : '' }}>Utmanzai</option>
    <option value="Vehari" {{ old('city') == 'Vehari' ? 'selected' : '' }}>Vehari</option>
    <option value="Wah Cantonment" {{ old('city') == 'Wah Cantonment' ? 'selected' : '' }}>Wah Cantonment</option>
    <option value="Wan Bhachran" {{ old('city') == 'Wan Bhachran' ? 'selected' : '' }}>Wan Bhachran</option>
    <option value="Warburton" {{ old('city') == 'Warburton' ? 'selected' : '' }}>Warburton</option>
    <option value="Wazirabad" {{ old('city') == 'Wazirabad' ? 'selected' : '' }}>Wazirabad</option>
    <option value="Yazman" {{ old('city') == 'Yazman' ? 'selected' : '' }}>Yazman</option>
    <option value="Zafarwal" {{ old('city') == 'Zafarwal' ? 'selected' : '' }}>Zafarwal</option>
    <option value="Zahir Pir" {{ old('city') == 'Zahir Pir' ? 'selected' : '' }}>Zahir Pir</option>
        </select>

        @error('city')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    
        <!-- Gender Field -->
<div>
    <label for="gender" class="block text-xs text-gray-400 mb-1.5">Gender</label>
    <select name="gender" id="gender"
            class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-indigo-600"
            required>
        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
        <option value="male"   {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
        <option value="other"  {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
    </select>
    @error('gender')
        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
    @enderror
</div>

<!-- Phone & WhatsApp - Side by Side -->
<div class="grid grid-cols-2 gap-4">
    <!-- Phone Field -->
    <div>
        <label for="phone" class="block text-xs text-gray-400 mb-1.5">Phone Number</label>
        <input type="tel" 
               name="phone" 
               id="phone"
               value="{{ old('phone') }}"
               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-indigo-600"
               placeholder="0300 1234567" required>
        @error('phone')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- WhatsApp Field -->
    <div>
        <label for="whatsapp" class="block text-xs text-gray-400 mb-1.5">WhatsApp Number</label>
        <input type="tel" 
               name="whatsapp" 
               id="whatsapp"
               value="{{ old('whatsapp') }}"
               class="w-full bg-gray-800 border border-gray-700 text-white rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:border-indigo-600"
               placeholder="+92 300 1234567" required>
        @error('whatsapp')
            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>

        
    

    
</div>

                
                <!-- Submit -->
                <div class="space-y-3 pt-2">
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3.5 rounded-xl text-sm transition disabled:opacity-60"
                            id="submit-btn">
                        Submit for Review
                    </button>

                    <p class="text-center text-xs text-gray-600">
                        By submitting you agree to our KYC & privacy policy
                    </p>
                </div>

            </form>

        <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50">
    
    <!-- Close Button -->
    <button id="closeModal" class="absolute top-5 right-5 text-white text-2xl font-bold">
        ✕
    </button>

    <!-- Image -->
    <img id="modalImage" class="max-w-[90%] max-h-[90%] rounded-lg shadow-lg border border-gray-700">
</div>

        @include('user.includes.profile_bottom_nav')
    </div>
    

    @include('user.includes.bottom_navigation')

    <script>
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const closeBtn = document.getElementById('closeModal');

    document.querySelectorAll('.sample-img').forEach(img => {
        img.addEventListener('click', function () {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modalImg.src = this.src;
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Optional: close on background click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>
    <script>
document.addEventListener('DOMContentLoaded', () => {

    const previewMap = {
        selfie: document.getElementById('selfie-preview'),
        front:  document.getElementById('front-preview'),
        back:   document.getElementById('back-preview')
    };

    Object.keys(previewMap).forEach(key => {
        const input = document.getElementById(key);
        const previewBox = previewMap[key];

        if (!input || !previewBox) return;

        input.addEventListener('change', function () {

            const file = this.files[0];
            if (!file) return;

            // ✅ File size check (important for mobile)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image must be less than 2MB');
                this.value = '';
                return;
            }

            // ✅ Type check
            if (!file.type.startsWith('image/')) {
                alert('Invalid file type');
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';

                // ✅ safer than innerHTML
                previewBox.replaceChildren(img);
            };

            reader.onerror = function () {
                alert('Failed to read file');
            };

            reader.readAsDataURL(file);
        });
    });

    // ✅ Safe form handling
    const form = document.querySelector('form');
    const btn = document.getElementById('submit-btn');

    if (form && btn) {
        form.addEventListener('submit', () => {
            btn.disabled = true;
        });
    }

});
</script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput   = document.getElementById('city-search');
    const listContainer = document.getElementById('city-list');
    const realSelect    = document.getElementById('city');
    const dropdown      = document.getElementById('city-dropdown');

    function populateList(options) {
        listContainer.innerHTML = '';

        if (options.length === 0) {
            const noResult = document.createElement('div');
            noResult.className = 'px-4 py-3 text-gray-500 text-center';
            noResult.textContent = 'No city found';
            listContainer.appendChild(noResult);
            return;
        }

        options.forEach(option => {
            const item = document.createElement('div');
            item.className = `px-4 py-2.5 hover:bg-gray-700 cursor-pointer transition-colors ${option.selected ? 'bg-indigo-600 text-white' : 'text-gray-200'}`;
            item.textContent = option.text;
            item.dataset.value = option.value;

            item.addEventListener('click', () => {
                realSelect.value = option.value;
                searchInput.value = option.text;
                listContainer.classList.add('hidden');
            });

            listContainer.appendChild(item);
        });
    }

    // Show list when clicking the input
    searchInput.addEventListener('focus', () => {
        populateList(Array.from(realSelect.options).slice(1));
        listContainer.classList.remove('hidden');
    });

    // Filter on typing
    searchInput.addEventListener('input', () => {
        const term = searchInput.value.toLowerCase().trim();

        const filtered = Array.from(realSelect.options).slice(1).filter(opt => 
            opt.text.toLowerCase().includes(term)
        );

        populateList(filtered);
        listContainer.classList.remove('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            listContainer.classList.add('hidden');
        }
    });

    // Pre-fill value if form was reloaded with error
    if (realSelect.value) {
        const selected = realSelect.options[realSelect.selectedIndex];
        if (selected) searchInput.value = selected.text;
    }
});
</script>

</body>
</html>
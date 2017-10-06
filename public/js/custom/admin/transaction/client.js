$(document).ready(function() {
    var adminid, clientid;

    var abra = [
        "Bangued", 
        "Boliney", 
        "Bucay", 
        "Bucloc", 
        "Daguioman", 
        "Danglas", 
        "Dolores", 
        "La Paz", 
        "Lacub", 
        "Lagangilang", 
        "Lagayan",
        "Langiden",
        "Licuan-Baay (Licuan)",
        "Luba",
        "Malibcong",
        "Manabo",
        "Peñarrubia",
        "Pidigan",
        "Pilar",
        "Sallapadan",
        "San Isidro",
        "San Juan",
        "San Quintin",
        "Tayum",
        "Tineg",
        "Tubo",
        "Villaviciosa",
    ];
    var agusandelnorte = [
        "Buenavista",
        "Butuan",
        "Cabadbaran",
        "Carmen",
        "Jabonga",
        "Kitcharao",
        "Las Nieves",
        "Magallanes",
        "Nasipit",
        "Remedios T. Romualdez",
        "Santiago",
        "Tubay",
    ];
    var agusandelsur = [
        "Bayugan",
        "Bunawan",
        "Esperanza",
        "La Paz",
        "Loreto",
        "Prosperidad",
        "Rosario",
        "San Francisco",
        "San Luis",
        "Santa Josefa",
        "Sibagat",
        "Talacogon",
        "Trento",
        "Veruela",
    ];
    var aklan = [
        "Altavas",
        "Balete",
        "Banga",
        "Batan",
        "Buruanga",
        "Ibajay",
        "Kalibo",
        "Lezo",
        "Libacao",
        "Madalag",
        "Makato",
        "Malay",
        "Malinao",
        "Nabas",
        "New Washington",
        "Numancia",
        "Tangalan",
    ];
    var albay = [
        "Bacacay",
        "Camalig",
        "Daraga (Locsin)",
        "Guinobatan",
        "Jovellar",
        "Legazpi",
        "Libon",
        "Ligao",
        "Malilipot",
        "Malinao",
        "Manito",
        "Oas",
        "Pio Duran",
        "Polangui",
        "Rapu-Rapu",
        "Santo Domingo (Libog)",
        "Tabaco",
        "Tiwi",
    ];
    var antique = [
        "Anini-y",
        "Barbaza",
        "Belison",
        "Bugasong",
        "Caluya",
        "Culasi",
        "Hamtic",
        "Laua-an",
        "Libertad",
        "Pandan",
        "Patnongon",
        "San Jose de Buenavista",
        "San Remigio",
        "Sebaste",
        "Sibalom",
        "Tibiao",
        "Tobias Fornier (Dao)",
        "Valderrama",
    ];
    var apayao = [
        "Calanasan (Bayag)",
        "Conner",
        "Flora",
        "Kabugao",
        "Luna",
        "Pudtol",
        "Santa Marcela",
    ];
    var aurora = [
        "Baler",
        "Casiguran",
        "Dilasag",
        "Dinalungan",
        "Dingalan",
        "Dipaculao",
        "Maria Aurora",
        "San Luis",
    ];
    var basilan = [
        "Akbar",
        "Al-Barka",
        "Hadji Mohammad Ajul",
        "Hadji Muhtamad",
        "Isabela City",
        "Lamitan",
        "Lantawan",
        "Maluso",
        "Sumisip",
        "Tabuan-Lasa",
        "Tipo-Tipo",
        "Tuburan",
        "Ungkaya Pukan",
    ];
    var bataan = [
        "Abucay",
        "Bagac",
        "Balanga",
        "Dinalupihan",
        "Hermosa",
        "Limay",
        "Mariveles",
        "Morong",
        "Orani",
        "Orion",
        "Pilar",
        "Samal",
    ];
    var batanes = [
        "Basco",
        "Itbayat",
        "Ivana",
        "Mahatao",
        "Sabtang",
        "Uyugan",
    ];
    var batangas = [
        "Agoncillo",
        "Alitagtag",
        "Balayan",
        "Balete",
        "Batangas City",
        "Bauan",
        "Calaca",
        "Calatagan",
        "Cuenca",
        "Ibaan",
        "Laurel",
        "Lemery",
        "Lian",
        "Lipa",
        "Lobo",
        "Mabini",
        "Malvar",
        "Mataasnakahoy",
        "Nasugbu",
        "Padre Garcia",
        "Rosario",
        "San Jose",
        "San Juan",
        "San Luis",
        "San Nicolas",
        "San Pascual",
        "Santa Teresita",
        "Santo Tomas",
        "Taal",
        "Talisay",
        "Tanauan",
        "Taysan",
        "Tingloy",
        "Tuy",
    ];
    var benguet = [
        "Atok",
        "Baguio",
        "Bakun",
        "Bokod",
        "Buguias",
        "Itogon",
        "Kabayan",
        "Kapangan",
        "Kibungan",
        "La Trinidad",
        "Mankayan",
        "Sablan",
        "Tuba",
        "Tublay",
    ];
    var biliran = [
        "Almeria",
        "Biliran",
        "Cabucgayan",
        "Caibiran",
        "Culaba",
        "Kawayan",
        "Maripipi",
        "Naval",
    ];
    var bohol = [
        "Alburquerque",
        "Alicia",
        "Anda",
        "Antequera",
        "Baclayon",
        "Balilihan",
        "Batuan",
        "Bien Unido",
        "Bilar",
        "Buenavista",
        "Calape",
        "Candijay",
        "Carmen",
        "Catigbian",
        "Clarin",
        "Corella",
        "Cortes",
        "Dagohoy",
        "Danao",
        "Dauis",
        "Dimiao",
        "Duero",
        "Garcia Hernandez",
        "Getafe",
        "Guindulman",
        "Inabanga",
        "Jagna",
        "Lila",
        "Loay",
        "Loboc",
        "Loon",
        "Mabini",
        "Maribojoc",
        "Panglao",
        "Pilar",
        "President Carlos P. Garcia (Pitogo)",
        "Sagbayan (Borja)",
        "San Isidro",
        "San Miguel",
        "Sevilla",
        "Sierra Bullones",
        "Sikatuna",
        "Tagbilaran",
        "Talibon",
        "Trinidad",
        "Tubigon",
        "Ubay",
        "Valencia",
    ];
    var bukidnon = [
        "Baungon",
        "Cabanglasan",
        "Damulog",
        "Dangcagan",
        "Don Carlos",
        "Impasugong",
        "Kadingilan",
        "Kalilangan",
        "Kibawe",
        "Kitaotao",
        "Lantapan",
        "Libona",
        "Malaybalay",
        "Malitbog",
        "Manolo Fortich",
        "Maramag",
        "Pangantucan",
        "Quezon",
        "San Fernando",
        "Sumilao",
        "Talakag",
        "Valencia",
    ];
    var bulacan = [
        "Angat",
        "Balagtas (Bigaa)",
        "Baliuag",
        "Bocaue",
        "Bulakan",
        "Bustos",
        "Calumpit",
        "Doña Remedios Trinidad",
        "Guiguinto",
        "Hagonoy",
        "Malolos",
        "Marilao",
        "Meycauayan",
        "Norzagaray",
        "Obando",
        "Pandi",
        "Paombong",
        "Plaridel",
        "Pulilan",
        "San Ildefonso",
        "San Jose del Monte",
        "San Miguel",
        "San Rafael",
        "Santa Maria",
    ];
    var cagayan = [
        "Abulug",
        "Alcala",
        "Allacapan",
        "Amulung",
        "Aparri",
        "Baggao",
        "Ballesteros",
        "Buguey",
        "Calayan",
        "Camalaniugan",
        "Claveria",
        "Enrile",
        "Gattaran",
        "Gonzaga",
        "Iguig",
        "Lal-lo",
        "Lasam",
        "Pamplona",
        "Peñablanca",
        "Piat",
        "Rizal",
        "Sanchez-Mira",
        "Santa Ana",
        "Santa Praxedes",
        "Santa Teresita",
        "Santo Niño (Faire)",
        "Solana",
        "Tuao",
        "Tuguegarao",
    ];
    var camarinesnorte = [
        "Basud",
        "Capalonga",
        "Daet",
        "Jose Panganiban",
        "Labo",
        "Mercedes",
        "Paracale",
        "San Lorenzo Ruiz (Imelda)",
        "San Vicente",
        "Santa Elena",
        "Talisay",
        "Vinzons",
    ];
    var camarinessur = [
        "Baao",
        "Balatan",
        "Bato",
        "Bombon",
        "Buhi",
        "Bula",
        "Cabusao",
        "Calabanga",
        "Camaligan",
        "Canaman",
        "Caramoan",
        "Del Gallego",
        "Gainza",
        "Garchitorena",
        "Goa",
        "Iriga",
        "Lagonoy",
        "Libmanan",
        "Lupi",
        "Magarao",
        "Milaor",
        "Minalabac",
        "Nabua",
        "Naga",
        "Ocampo",
        "Pamplona",
        "Pasacao",
        "Pili",
        "Presentacion (Parubcan)",
        "Ragay",
        "Sagñay",
        "San Fernando",
        "San Jose",
        "Sipocot",
        "Siruma",
        "Tigaon",
        "Tinambac",
    ];
    var camiguin = [
        "Catarman",
        "Guinsiliban",
        "Mahinog",
        "Mambajao",
        "Sagay",
    ];
    var capiz = [
        "Cuartero",
        "Dao",
        "Dumalag",
        "Dumarao",
        "Ivisan",
        "Jamindan",
        "Maayon",
        "Mambusao",
        "Panay",
        "Panitan",
        "Pilar",
        "Pontevedra",
        "President Roxas",
        "Roxas City",
        "Sapian",
        "Sigma",
        "Tapaz",
    ];
    var catanduanes = [
        "Bagamanoc",
        "Baras",
        "Bato",
        "Caramoran",
        "Gigmoto",
        "Pandan",
        "Panganiban (Payo)",
        "San Andres (Calolbon)",
        "San Miguel",
        "Viga",
        "Virac",
    ];
    var cavite = [
        "Alfonso",
        "Amadeo",
        "Bacoor",
        "Carmona",
        "Cavite City",
        "Dasmariñas",
        "General Emilio Aguinaldo",
        "General Mariano Alvarez",
        "General Trias",
        "Imus",
        "Indang",
        "Kawit",
        "Magallanes",
        "Maragondon",
        "Mendez (Mendez-Nuñez)",
        "Naic",
        "Noveleta",
        "Rosario",
        "Silang",
        "Tagaytay",
        "Tanza",
        "Ternate",
        "Trece Martires",
    ];
    var cebu = [
        "Alcantara",
        "Alcoy",
        "Alegria",
        "Aloguinsan",
        "Argao",
        "Asturias",
        "Badian",
        "Balamban",
        "Bantayan",
        "Barili",
        "Bogo",
        "Boljoon",
        "Borbon",
        "Carcar",
        "Carmen",
        "Catmon",
        "Cebu City",
        "Compostela",
        "Consolacion",
        "Cordova",
        "Daanbantayan",
        "Dalaguete",
        "Danao",
        "Dumanjug",
        "Ginatilan",
        "Lapu-Lapu (Opon)",
        "Liloan",
        "Madridejos",
        "Malabuyoc",
        "Mandaue",
        "Medellin",
        "Minglanilla",
        "Moalboal",
        "Naga",
        "Oslob",
        "Pilar",
        "Pinamungajan",
        "Poro",
        "Ronda",
        "Samboan",
        "San Fernando",
        "San Francisco",
        "San Remigio",
        "Santa Fe",
        "Santander",
        "Sibonga",
        "Sogod",
        "Tabogon",
        "Tabuelan",
        "Talisay",
        "Toledo",
        "Tuburan",
        "Tudela",
    ];
    var compostellavalley = [
        "Laak (San Vicente)",
        "Mabini (Doña Alicia)",
        "Maco",
        "Maragusan (San Mariano)",
        "Mawab",
        "Monkayo",
        "Montevista",
        "Nabunturan",
        "New Bataan",
        "Pantukan",
    ];
    var cotabato = [
        "Alamada",
        "Aleosan",
        "Antipas",
        "Arakan",
        "Banisilan",
        "Carmen",
        "Kabacan",
        "Kidapawan",
        "Libungan",
        "M'lang",
        "Magpet",
        "Makilala",
        "Matalam",
        "Midsayap",
        "Pigcawayan",
        "Pikit",
        "President Roxas",
        "Tulunan",
    ];
    var davaodelnorte = [
        "Asuncion (Saug)",
        "Braulio E. Dujali",
        "Carmen",
        "Kapalong",
        "New Corella",
        "Panabo",
        "Samal",
        "San Isidro",
        "Santo Tomas",
        "Tagum",
        "Talaingod",
    ];
    var davaodelsur = [
        "Bansalan",
        "Davao City",
        "Digos",
        "Hagonoy",
        "Kiblawan",
        "Magsaysay",
        "Malalag",
        "Matanao",
        "Padada",
        "Santa Cruz",
        "Sulop",
    ];
    var davaooccidental = [
        "Don Marcelino",
        "Jose Abad Santos (Trinidad)",
        "Malita",
        "Santa Maria",
        "Sarangani",
    ];
    var davaooriental = [
        "Baganga",
        "Banaybanay",
        "Boston",
        "Caraga",
        "Cateel",
        "Governor Generoso",
        "Lupon",
        "Manay",
        "Mati",
        "San Isidro",
        "Tarragona",
    ];
    var dinagatislands = [
        "Basilisa (Rizal)",
        "Cagdianao",
        "Dinagat",
        "Libjo (Albor)",
        "Loreto",
        "San Jose",
        "Tubajon",
    ];
    var easternsamar = [
        "Arteche",
        "Balangiga",
        "Balangkayan",
        "Borongan",
        "Can-avid",
        "Dolores",
        "General MacArthur",
        "Giporlos",
        "Guiuan",
        "Hernani",
        "Jipapad",
        "Lawaan",
        "Llorente",
        "Maslog",
        "Maydolong",
        "Mercedes",
        "Oras",
        "Quinapondan",
        "Salcedo",
        "San Julian",
        "San Policarpo",
        "Sulat",
        "Taft",
    ];
    var guimaras = [
        "Buenavista",
        "Jordan",
        "Nueva Valencia",
        "San Lorenzo",
        "Sibunag",
    ];
    var ifugao = [
        "Aguinaldo",
        "Alfonso Lista (Potia)",
        "Asipulo",
        "Banaue",
        "Hingyon",
        "Hungduan",
        "Kiangan",
        "Lagawe",
        "Lamut",
        "Mayoyao",
        "Tinoc",
    ];
    var ilocosnorte = [
        "Adams",
        "Bacarra",
        "Badoc",
        "Bangui",
        "Banna (Espiritu)",
        "Batac",
        "Burgos",
        "Carasi",
        "Currimao",
        "Dingras",
        "Dumalneg",
        "Laoag",
        "Marcos",
        "Nueva Era",
        "Pagudpud",
        "Paoay",
        "Pasuquin",
        "Piddig",
        "Pinili",
        "San Nicolas",
        "Sarrat",
        "Solsona",
        "Vintar",
    ];
    var ilocossur = [
        "Alilem",
        "Banayoyo",
        "Bantay",
        "Burgos",
        "Cabugao",
        "Candon",
        "Caoayan",
        "Cervantes",
        "Galimuyod",
        "Gregorio del Pilar (Concepcion)",
        "Lidlidda",
        "Magsingal",
        "Nagbukel",
        "Narvacan",
        "Quirino (Angkaki)",
        "Salcedo (Baugen)",
        "San Emilio",
        "San Esteban",
        "San Ildefonso",
        "San Juan (Lapog)",
        "San Vicente",
        "Santa",
        "Santa Catalina",
        "Santa Cruz",
        "Santa Lucia",
        "Santa Maria",
        "Santiago",
        "Santo Domingo",
        "Sigay",
        "Sinait",
        "Sugpon",
        "Suyo",
        "Tagudin",
        "Vigan",
    ];
    var iloilo = [
        "Ajuy",
        "Alimodian",
        "Anilao",
        "Badiangan",
        "Balasan",
        "Banate",
        "Barotac Nuevo",
        "Barotac Viejo",
        "Batad",
        "Bingawan",
        "Cabatuan",
        "Calinog",
        "Carles",
        "Concepcion",
        "Dingle",
        "Dueñas",
        "Dumangas",
        "Estancia",
        "Guimbal",
        "Igbaras",
        "Iloilo City",
        "Janiuay",
        "Lambunao",
        "Leganes",
        "Lemery",
        "Leon",
        "Maasin",
        "Miagao",
        "Mina",
        "New Lucena",
        "Oton",
        "Passi",
        "Pavia",
        "Pototan",
        "San Dionisio",
        "San Enrique",
        "San Joaquin",
        "San Miguel",
        "San Rafael",
        "Santa Barbara",
        "Sara",
        "Tigbauan",
        "Tubungan",
        "Zarraga",
    ];
    var isabela = [
        "Alicia",
        "Angadanan",
        "Aurora",
        "Benito Soliven",
        "Burgos",
        "Cabagan",
        "Cabatuan",
        "Cauayan",
        "Cordon",
        "Delfin Albano (Magsaysay)",
        "Dinapigue",
        "Divilacan",
        "Echague",
        "Gamu",
        "Ilagan",
        "Jones",
        "Luna",
        "Maconacon",
        "Mallig",
        "Naguilian",
        "Palanan",
        "Quezon",
        "Quirino",
        "Ramon",
        "Reina Mercedes",
        "Roxas",
        "San Agustin",
        "San Guillermo",
        "San Isidro",
        "San Manuel (Callang)",
        "San Mariano",
        "San Mateo",
        "San Pablo",
        "Santa Maria",
        "Santiago",
        "Santo Tomas",
        "Tumauini",
    ];
    var kalinga = [
        "Balbalan",
        "Lubuagan",
        "Pasil",
        "Pinukpuk",
        "Rizal (Liwan)",
        "Tabuk",
        "Tanudan",
        "Tinglayan",
    ];
    var launion = [
        "Agoo",
        "Aringay",
        "Bacnotan",
        "Bagulin",
        "Balaoan",
        "Bangar",
        "Bauang",
        "Burgos",
        "Caba",
        "Luna",
        "Naguilian",
        "Pugo",
        "Rosario",
        "San Fernando",
        "San Gabriel",
        "San Juan",
        "Santo Tomas",
        "Santol",
        "Sudipen",
        "Tubao",
    ];
    var laguna = [
        "Alaminos",
        "Bay",
        "Biñan",
        "Cabuyao",
        "Calamba",
        "Calauan",
        "Cavinti",
        "Famy",
        "Kalayaan",
        "Liliw",
        "Los Baños",
        "Luisiana",
        "Lumban",
        "Mabitac",
        "Magdalena",
        "Majayjay",
        "Nagcarlan",
        "Paete",
        "Pagsanjan",
        "Pakil",
        "Pangil",
        "Pila",
        "Rizal",
        "San Pablo",
        "San Pedro",
        "Santa Cruz",
        "Santa Maria",
        "Santa Rosa",
        "Siniloan",
        "Victoria",
    ];
    var lanaodelnorte = [
        "Bacolod",
        "Baloi",
        "Baroy",
        "Iligan",
        "Kapatagan",
        "Kauswagan",
        "Kolambugan",
        "Lala",
        "Linamon",
        "Magsaysay",
        "Maigo",
        "Matungao",
        "Munai",
        "Nunungan",
        "Pantao Ragat",
        "Pantar",
        "Poona Piagapo",
        "Salvador",
        "Sapad",
        "Sultan Naga Dimaporo (Karomatan)",
        "Tagoloan",
        "Tangcal",
        "Tubod",
    ];
    var lanaodelsur = [
        "Amai Manabilang (Bumbaran)",
        "Bacolod-Kalawi (Bacolod-Grande)",
        "Balabagan",
        "Balindong (Watu)",
        "Bayang",
        "Binidayan",
        "Buadiposo-Buntong",
        "Bubong",
        "Butig",
        "Calanogas",
        "Ditsaan-Ramain",
        "Ganassi",
        "Kapai",
        "Kapatagan",
        "Lumba-Bayabao (Maguing)",
        "Lumbaca-Unayan",
        "Lumbatan",
        "Lumbayanague",
        "Madalum",
        "Madamba",
        "Maguing",
        "Malabang",
        "Marantao",
        "Marawi",
        "Marogong",
        "Masiu",
        "Mulondo",
        "Pagayawan (Tatarikan)",
        "Piagapo",
        "Picong (Sultan Gumander)",
        "Poona Bayabao (Gata)",
        "Pualas",
        "Saguiaran",
        "Sultan Dumalondong",
        "Tagoloan II",
        "Tamparan",
        "Taraka",
        "Tubaran",
        "Tugaya",
        "Wao",
    ];
    var leyte = [
        "Abuyog",
        "Alangalang",
        "Albuera",
        "Babatngon",
        "Barugo",
        "Bato",
        "Baybay",
        "Burauen",
        "Calubian",
        "Capoocan",
        "Carigara",
        "Dagami",
        "Dulag",
        "Hilongos",
        "Hindang",
        "Inopacan",
        "Isabel",
        "Jaro",
        "Javier (Bugho)",
        "Julita",
        "Kananga",
        "La Paz",
        "Leyte",
        "MacArthur",
        "Mahaplag",
        "Matag-ob",
        "Matalom",
        "Mayorga",
        "Merida",
        "Ormoc",
        "Palo",
        "Palompon",
        "Pastrana",
        "San Isidro",
        "San Miguel",
        "Santa Fe",
        "Tabango",
        "Tabontabon",
        "Tacloban",
        "Tanauan",
        "Tolosa",
        "Tunga",
        "Villaba",
    ];
    var maguindanao = [
        "Ampatuan",
        "Barira",
        "Buldon",
        "Buluan",
        "Cotabato City",
        "Datu Abdullah Sangki",
        "Datu Anggal Midtimbang",
        "Datu Blah T. Sinsuat",
        "Datu Hoffer Ampatuan",
        "Datu Montawal (Pagagawan)",
        "Datu Odin Sinsuat  (Dinaig)",
        "Datu Paglas",
        "Datu Piang (Dulawan)",
        "Datu Salibo",
        "Datu Saudi-Ampatuan",
        "Datu Unsay",
        "General Salipada K. Pendatun",
        "Guindulungan",
        "Kabuntalan (Tumbao)",
        "Mamasapano",
        "Mangudadatu",
        "Matanog",
        "Northern Kabuntalan",
        "Pagalungan",
        "Paglat",
        "Pandag",
        "Parang",
        "Rajah Buayan",
        "Shariff Aguak (Maganoy)",
        "Shariff Saydona Mustapha",
        "South Upi",
        "Sultan Kudarat (Nuling)",
        "Sultan Mastura",
        "Sultan sa Barongis (Lambayong)",
        "Sultan Sumagka (Talitay)",
        "Talayan",
        "Upi",
    ];
    var marinduque = [
        "Boac",
        "Buenavista",
        "Gasan",
        "Mogpog",
        "Santa Cruz",
        "Torrijos",
    ];
    var masbate = [
        "Aroroy",
        "Baleno",
        "Balud",
        "Batuan",
        "Cataingan",
        "Cawayan",
        "Claveria",
        "Dimasalang",
        "Esperanza",
        "Mandaon",
        "Masbate City",
        "Milagros",
        "Mobo",
        "Monreal",
        "Palanas",
        "Pio V. Corpuz (Limbuhan)",
        "Placer",
        "San Fernando",
        "San Jacinto",
        "San Pascual",
        "Uson",
    ];
    var metromanila = [
        "Caloocan",
        "Las Piñas",
        "Makati",
        "Malabon",
        "Mandaluyong",
        "Manila",
        "Marikina",
        "Muntinlupa",
        "Navotas",
        "Parañaque",
        "Pasay",
        "Pasig",
        "Pateros",
        "Quezon City",
        "San Juan",
        "Taguig",
        "Valenzuela",
    ];
    var misamisoccidental = [
        "Aloran",
        "Baliangao",
        "Bonifacio",
        "Calamba",
        "Clarin",
        "Concepcion",
        "Don Victoriano Chiongbian (Don Mariano Marcos)",
        "Jimenez",
        "Lopez Jaena",
        "Oroquieta",
        "Ozamiz",
        "Panaon",
        "Plaridel",
        "Sapang Dalaga",
        "Sinacaban",
        "Tangub",
        "Tudela",
    ];
    var misamisoriental = [
        "Alubijid",
        "Balingasag",
        "Balingoan",
        "Binuangan",
        "Cagayan de Oro",
        "Claveria",
        "El Salvador",
        "Gingoog",
        "Gitagum",
        "Initao",
        "Jasaan",
        "Kinoguitan",
        "Lagonglong",
        "Laguindingan",
        "Libertad",
        "Lugait",
        "Magsaysay (Linugos)",
        "Manticao",
        "Medina",
        "Naawan",
        "Opol",
        "Salay",
        "Sugbongcogon",
        "Tagoloan",
        "Talisayan",
        "Villanueva",
    ];
    var mountainprovince = [
        "Barlig",
        "Bauko",
        "Besao",
        "Bontoc",
        "Natonin",
        "Paracelis",
        "Sabangan",
        "Sadanga",
        "Sagada",
        "Tadian",
    ];
    var negrosoccidental = [
        "Bacolod",
        "Bago",
        "Binalbagan",
        "Cadiz",
        "Calatrava",
        "Candoni",
        "Cauayan",
        "Enrique B. Magalona (Saravia)",
        "Escalante",
        "Himamaylan",
        "Hinigaran",
        "Hinoba-an (Asia)",
        "Ilog",
        "Isabela",
        "Kabankalan",
        "La Carlota",
        "La Castellana",
        "Manapla",
        "Moises Padilla (Magallon)",
        "Murcia",
        "Pontevedra",
        "Pulupandan",
        "Sagay",
        "Salvador Benedicto",
        "San Carlos",
        "San Enrique",
        "Silay",
        "Sipalay",
        "Talisay",
        "Toboso",
        "Valladolid",
        "Victorias",
    ];
    var negrosoriental = [
        "Amlan (Ayuquitan)",
        "Ayungon",
        "Bacong",
        "Bais",
        "Basay",
        "Bayawan (Tulong)",
        "Bindoy (Payabon)",
        "Canlaon",
        "Dauin",
        "Dumaguete",
        "Guihulngan",
        "Jimalalud",
        "La Libertad",
        "Mabinay",
        "Manjuyod",
        "Pamplona",
        "San Jose",
        "Santa Catalina",
        "Siaton",
        "Sibulan",
        "Tanjay",
        "Tayasan",
        "Valencia (Luzurriaga)",
        "Vallehermoso",
        "Zamboanguita",
    ];
    var northernsamar = [
        "Allen",
        "Biri",
        "Bobon",
        "Capul",
        "Catarman",
        "Catubig",
        "Gamay",
        "Laoang",
        "Lapinig",
        "Las Navas",
        "Lavezares",
        "Lope de Vega",
        "Mapanas",
        "Mondragon",
        "Palapag",
        "Pambujan",
        "Rosario",
        "San Antonio",
        "San Isidro",
        "San Jose",
        "San Roque",
        "San Vicente",
        "Silvino Lobos",
        "Victoria",
    ];
    var nuevaecija = [
        "Aliaga",
        "Bongabon",
        "Cabanatuan",
        "Cabiao",
        "Carranglan",
        "Cuyapo",
        "Gabaldon (Bitulok & Sabani)",
        "Gapan",
        "General Mamerto Natividad",
        "General Tinio (Papaya)",
        "Guimba",
        "Jaen",
        "Laur",
        "Licab",
        "Llanera",
        "Lupao",
        "Muñoz",
        "Nampicuan",
        "Palayan",
        "Pantabangan",
        "Peñaranda",
        "Quezon",
        "Rizal",
        "San Antonio",
        "San Isidro",
        "San Jose",
        "San Leonardo",
        "Santa Rosa",
        "Santo Domingo",
        "Talavera",
        "Talugtug",
        "Zaragoza",
    ];
    var nuevavizcaya = [
        "Alfonso Castañeda",
        "Ambaguio",
        "Aritao",
        "Bagabag",
        "Bambang",
        "Bayombong",
        "Diadi",
        "Dupax del Norte",
        "Dupax del Sur",
        "Kasibu",
        "Kayapa",
        "Quezon",
        "Santa Fe (Imugan)",
        "Solano",
        "Villaverde (Ibung)",
    ];
    var occidentalmindoro = [
        "Abra de Ilog",
        "Calintaan",
        "Looc",
        "Lubang",
        "Magsaysay",
        "Mamburao",
        "Paluan",
        "Rizal",
        "Sablayan",
        "San Jose",
        "Santa Cruz",
    ];
    var orientalmindoro = [
        "Baco",
        "Bansud",
        "Bongabong",
        "Bulalacao (San Pedro)",
        "Calapan",
        "Gloria",
        "Mansalay",
        "Naujan",
        "Pinamalayan",
        "Pola",
        "Puerto Galera",
        "Roxas",
        "San Teodoro",
        "Socorro",
        "Victoria",
    ];
    var palawan = [
        "Aborlan",
        "Agutaya",
        "Araceli",
        "Balabac",
        "Bataraza",
        "Brooke's Point",
        "Busuanga",
        "Cagayancillo",
        "Coron",
        "Culion",
        "Cuyo",
        "Dumaran",
        "El Nido (Bacuit)",
        "Kalayaan",
        "Linapacan",
        "Magsaysay",
        "Narra",
        "Puerto Princesa",
        "Quezon",
        "Rizal (Marcos)",
        "Roxas",
        "San Vicente",
        "Sofronio Española",
        "Taytay",
    ];
    var pampanga = [
        "Angeles",
        "Apalit",
        "Arayat",
        "Bacolor",
        "Candaba",
        "Floridablanca",
        "Guagua",
        "Lubao",
        "Mabalacat",
        "Macabebe",
        "Magalang",
        "Masantol",
        "Mexico",
        "Minalin",
        "Porac",
        "San Fernando",
        "San Luis",
        "San Simon",
        "Santa Ana",
        "Santa Rita",
        "Santo Tomas",
        "Sasmuan (Sexmoan)",
    ];
    var pangasinan = [
        "Agno",
        "Aguilar",
        "Alaminos",
        "Alcala",
        "Anda",
        "Asingan",
        "Balungao",
        "Bani",
        "Basista",
        "Bautista",
        "Bayambang",
        "Binalonan",
        "Binmaley",
        "Bolinao",
        "Bugallon",
        "Burgos",
        "Calasiao",
        "Dagupan",
        "Dasol",
        "Infanta",
        "Labrador",
        "Laoac",
        "Lingayen",
        "Mabini",
        "Malasiqui",
        "Manaoag",
        "Mangaldan",
        "Mangatarem",
        "Mapandan",
        "Natividad",
        "Pozorrubio",
        "Rosales",
        "San Carlos",
        "San Fabian",
        "San Jacinto",
        "San Manuel",
        "San Nicolas",
        "San Quintin",
        "Santa Barbara",
        "Santa Maria",
        "Santo Tomas",
        "Sison",
        "Sual",
        "Tayug",
        "Umingan",
        "Urbiztondo",
        "Urdaneta",
        "Villasis",
    ];
    var quezon = [
        "Agdangan",
        "Alabat",
        "Atimonan",
        "Buenavista",
        "Burdeos",
        "Calauag",
        "Candelaria",
        "Catanauan",
        "Dolores",
        "General Luna",
        "General Nakar",
        "Guinayangan",
        "Gumaca",
        "Infanta",
        "Jomalig",
        "Lopez",
        "Lucban",
        "Lucena",
        "Macalelon",
        "Mauban",
        "Mulanay",
        "Padre Burgos",
        "Pagbilao",
        "Panukulan",
        "Patnanungan",
        "Perez",
        "Pitogo",
        "Plaridel",
        "Polillo",
        "Quezon",
        "Real",
        "Sampaloc",
        "San Andres",
        "San Antonio",
        "San Francisco (Aurora)",
        "San Narciso",
        "Sariaya",
        "Tagkawayan",
        "Tayabas",
        "Tiaong",
        "Unisan",
    ];
    var quirino = [
        "Aglipay",
        "Cabarroguis",
        "Diffun",
        "Maddela",
        "Nagtipunan",
        "Saguday",
    ];
    var rizal = [
        "Angono",
        "Antipolo",
        "Baras",
        "Binangonan",
        "Cainta",
        "Cardona",
        "Jalajala",
        "Morong",
        "Pililla",
        "Rodriguez (Montalban)",
        "San Mateo",
        "Tanay",
        "Taytay",
        "Teresa",
    ];
    var romblon = [
        "Alcantara",
        "Banton (Jones)",
        "Cajidiocan",
        "Calatrava",
        "Concepcion",
        "Corcuera",
        "Ferrol",
        "Looc",
        "Magdiwang",
        "Odiongan",
        "Romblon",
        "San Agustin",
        "San Andres",
        "San Fernando",
        "San Jose",
        "Santa Fe",
        "Santa Maria (Imelda)",
    ];
    var samar = [
        "Almagro",
        "Basey",
        "Calbayog",
        "Calbiga",
        "Catbalogan",
        "Daram",
        "Gandara",
        "Hinabangan",
        "Jiabong",
        "Marabut",
        "Matuguinao",
        "Motiong",
        "Pagsanghan",
        "Paranas (Wright)",
        "Pinabacdao",
        "San Jorge",
        "San Jose de Buan",
        "San Sebastian",
        "Santa Margarita",
        "Santa Rita",
        "Santo Niño",
        "Tagapul","-a","n",
        "Talalora",
        "Tarangnan",
        "Villareal",
        "Zumarraga",
    ];
    var sarangani = [
        "Alabel",
        "Glan",
        "Kiamba",
        "Maasim",
        "Maitum",
        "Malapatan",
        "Malungon",
    ];
    var siquijor = [
        "Enrique Villanue",
        "Larena",
        "Lazi",
        "Maria",
        "San Juan",
        "Siquijor",
    ];
    var sorsogon = [
        "Barcelona",
        "Bulan",
        "Bulusan",
        "Casiguran",
        "Castilla",
        "Donsol",
        "Gubat",
        "Irosin",
        "Juban",
        "Magallanes",
        "Matnog",
        "Pilar",
        "Prieto Diaz",
        "Santa Magdalena",
        "Sorsogon City",
    ];
    var southcotabato = [
        "Banga",
        "General Santos (Dadiangas)",
        "Koronadal",
        "Lake Sebu",
        "Norala",
        "Polomolok",
        "Santo Niño",
        "Surallah",
        "T'Boli",
        "Tampakan",
        "Tantangan",
        "Tupi",
    ];
    var southernleyte = [
        "Anahawan",
        "Bontoc",
        "Hinunangan",
        "Hinundayan",
        "Libagon",
        "Liloan",
        "Limasawa",
        "Maasin",
        "Macrohon",
        "Malitbog",
        "Padre Burgos",
        "Pintuyan",
        "Saint Bernard",
        "San Francisco",
        "San Juan (Cabalian)",
        "San Ricardo",
        "Silago",
        "Sogod",
        "Tomas Oppus",
    ];
    var sultankudarat = [
        "Bagumbayan",
        "Columbio",
        "Esperanza",
        "Isulan",
        "Kalamansig",
        "Lambayong (Mariano Marcos)",
        "Lebak",
        "Lutayan",
        "Palimbang",
        "President Quirino",
        "Senator Ninoy Aquino",
        "Tacurong",
    ];
    var sulu = [
        "Banguingui (Tongkil)",
        "Hadji Panglima Tahil (Marunggas)",
        "Indanan",
        "Jolo",
        "Kalingalan Caluang",
        "Lugus",
        "Luuk",
        "Maimbung",
        "Old Panamao",
        "Omar",
        "Pandami",
        "Panglima Estino (New Panamao)",
        "Pangutaran",
        "Parang",
        "Pata",
        "Patikul",
        "Siasi",
        "Talipao",
        "Tapul",
    ];
    var surigaodelnorte = [
        "Alegria",
        "Bacuag",
        "Burgos",
        "Claver",
        "Dapa",
        "Del Carmen",
        "General Luna",
        "Gigaquit",
        "Mainit",
        "Malimono",
        "Pilar",
        "Placer",
        "San Benito",
        "San Francisco (Anao-Aon)",
        "San Isidro",
        "Santa Monica (Sapao)",
        "Sison",
        "Socorro",
        "Surigao City",
        "Tagana-an",
        "Tubod",
    ];
    var surigaodelsur = [
        "Barobo",
        "Bayabas",
        "Bislig",
        "Cagwait",
        "Cantilan",
        "Carmen",
        "Carrascal",
        "Cortes",
        "Hinatuan",
        "Lanuza",
        "Lianga",
        "Lingig",
        "Madrid",
        "Marihatag",
        "San Agustin",
        "San Miguel",
        "Tagbina",
        "Tago",
        "Tandag",
    ];
    var tarlac = [
        "Anao",
        "Bamban",
        "Camiling",
        "Capas",
        "Concepcion",
        "Gerona",
        "La Paz",
        "Mayantoc",
        "Moncada",
        "Paniqui",
        "Pura",
        "Ramos",
        "San Clemente",
        "San Jose",
        "San Manuel",
        "Santa Ignacia",
        "Tarlac City",
        "Victoria",
    ];
    var tawitawi = [
        "Bongao",
        "Languyan",
        "Mapun (Cagayan de Tawi-Tawi)",
        "Panglima Sugala (Balimbing)",
        "Sapa-Sapa",
        "Sibutu",
        "Simunul",
        "Sitangkai",
        "South Ubian",
        "Tandubas",
        "Turtle Islands (Taganak)",
    ];
    var zambales = [
        "Botolan",
        "Cabangan",
        "Candelaria",
        "Castillejos",
        "Iba",
        "Masinloc",
        "Olongapo",
        "Palauig",
        "San Antonio",
        "San Felipe",
        "San Marcelino",
        "San Narciso",
        "Santa Cruz",
        "Subic",
    ];
    var zamboangadelnorte = [
        "Baliguian",
        "Dapitan",
        "Dipolog",
        "Godod",
        "Gutalac",
        "Jose Dalman (Ponot)",
        "Kalawit",
        "Katipunan",
        "La Libertad",
        "Labason",
        "Leon B. Postigo (Bacungan)",
        "Liloy",
        "Manukan",
        "Mutia",
        "Piñan (New Piñan)",
        "Polanco",
        "President Manuel A. Roxas",
        "Rizal",
        "Salug",
        "Sergio Osmeña Sr.",
        "Siayan",
        "Sibuco",
        "Sibutad",
        "Sindangan",
        "Siocon",
        "Sirawai",
    ];
    var zambaongadelsur = [
        "Tampilisan",
        "Aurora",
        "Bayog",
        "Dimataling",
        "Dinas",
        "Dumalinao",
        "Dumingag",
        "Guipos",
        "Josefina",
        "Kumalarang",
        "Labangan",
        "Lakewood",
        "Lapuyan",
        "Mahayag",
        "Margosatubig",
        "Midsalip",
        "Molave",
        "Pagadian",
        "Pitogo",
        "Ramon Magsaysay (Liargo)",
        "San Miguel",
        "San Pablo",
        "Sominot (Don Mariano Marcos)",
        "Tabina",
        "Tambulig",
        "Tigbao",
        "Tukuran",
        "Vincenzo A. Sagun",
        "Zamboanga City",
    ];
    var zamboangasibugay = [
        "Alicia",
        "Buug",
        "Diplahan",
        "Imelda",
        "Ipil",
        "Kabasalan",
        "Mabuhay",
        "Malangas",
        "Naga",
        "Olutanga",
        "Payao",
        "Roseller Lim",
        "Siay",
        "Talusan",
        "Titay",
        "Tungawan",
    ];

    //city address
    $('#inputProvince').on('change', function(e) {
        $('#inputCity').empty();
        $('#inputCity').append('<option></option');
        if ($(this).val() == 'Abra') {
            jQuery.each(abra, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Agusan Del Norte') {
            jQuery.each(agusandelnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Agusan Del Sur') {
            jQuery.each(agusandelsur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Aklan') {
            jQuery.each(aklan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Albay') {
            jQuery.each(albay, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Antique') {
            jQuery.each(antique, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Apayao') {
            jQuery.each(apayao, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Aurora') {
            jQuery.each(aurora, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Basilan') {
            jQuery.each(basilan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bataan') {
            jQuery.each(bataan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Batanes') {
            jQuery.each(batanes, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Batangas') {
            jQuery.each(batangas, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Benguet') {
            jQuery.each(benguet, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Biliran') {
            jQuery.each(biliran, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bohol') {
            jQuery.each(bohol, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bulacan') {
            jQuery.each(bulacan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bukidnon') {
            jQuery.each(bukidnon, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cagayan') {
            jQuery.each(cagayan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camarines Norte') {
            jQuery.each(camarinesnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camarines Sur') {
            jQuery.each(camarinessur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camiguin') {
            jQuery.each(camiguin, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Capiz') {
            jQuery.each(capiz, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Catanduanes') {
            jQuery.each(catanduanes, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cavite') {
            jQuery.each(cavite, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cebu') {
            jQuery.each(cebu, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Compostella Valley') {
            jQuery.each(compostellavalley, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cotabato') {
            jQuery.each(cotabato, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Del Norte') {
            jQuery.each(davaodelnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Del Sur') {
            jQuery.each(davaodelsur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Occidental') {
            jQuery.each(davaooccidental, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Oriental') {
            jQuery.each(davaooriental, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Dinagat Islands') {
            jQuery.each(dinagatislands, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Eastern Samar') {
            jQuery.each(easternsamar, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Guimaras') {
            jQuery.each(guimaras, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ifugao') {
            jQuery.each(ifugao, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ilocos Norte') {
            jQuery.each(ilocosnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ilocos Sur') {
            jQuery.each(ilocossur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Iloilo') {
            jQuery.each(iloilo, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Isabela') {
            jQuery.each(isabela, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Kalinga') {
            jQuery.each(kalinga, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'La Union') {
            jQuery.each(launion, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Laguna') {
            jQuery.each(laguna, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Lanao Del Norte') {
            jQuery.each(lanaodelnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Lanao Del Sur') {
            jQuery.each(lanaodelsur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Leyte') {
            jQuery.each(leyte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Maguindanao') {
            jQuery.each(maguindanao, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Marinduque') {
            jQuery.each(marinduque, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Masbate') {
            jQuery.each(masbate, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Metro Manila') {
            jQuery.each(metromanila, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Misamis Occidental') {
            jQuery.each(misamisoccidental, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Misamis Oriental') {
            jQuery.each(misamisoriental, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Mountain Province') {
            jQuery.each(mountainprovince, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Negros Occidental') {
            jQuery.each(negrosoccidental, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Negros Oriental') {
            jQuery.each(negrosoriental, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Northern Samar') {
            jQuery.each(northernsamar, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Neuva Ecija') {
            jQuery.each(nuevaecija, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Nueva Vizcaya') {
            jQuery.each(nuevavizcaya, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Occidental Mindoro') {
            jQuery.each(occidentalmindoro, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Oriental Mindoro') {
            jQuery.each(orientalmindoro, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Palawan') {
            jQuery.each(palawan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Pampanga') {
            jQuery.each(pampanga, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Pangasinan') {
            jQuery.each(pangasinan, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Quezon') {
            jQuery.each(quezon, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Quirino') {
            jQuery.each(quirino, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Rizal') {
            jQuery.each(rizal, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Romblon') {
            jQuery.each(romblon, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Samar') {
            jQuery.each(samar, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sarangani') {
            jQuery.each(sarangani, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Siquijor') {
            jQuery.each(siquijor, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sorsogon') {
            jQuery.each(sorsogon, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'South Cotabato') {
            jQuery.each(southcotabato, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Southern Leyte') {
            jQuery.each(southernleyte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sultan Kudarat') {
            jQuery.each(sultankudarat, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sulu') {
            jQuery.each(sulu, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Surigao Del Norte') {
            jQuery.each(surigaodelnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Surigao Del Sur') {
            jQuery.each(surigaodelsur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Tarlac') {
            jQuery.each(tarlac, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Tawi-Tawi') {
            jQuery.each(tawitawi, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zambales') {
            jQuery.each(zambales, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Del Norte') {
            jQuery.each(zamboangadelnorte, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Del Sur') {
            jQuery.each(zambaongadelsur, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Sibugay') {
            jQuery.each(zamboangasibugay, function(index, item) {
                $('#inputCity').append('<option value="'+item+'">'+item+'</option>');
            });
        }
    });

    //client table
    var table = $('#tblClient').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[0, 'asc']]).draw();

    //update the picture in the img source
    $("#picture").change(function() {
        readURL(this);
    });

    //date picker
    $('.mydatepicker').change(function() {
        $(this).parsley().validate();
    });
    $('#startdate').inputmask("9999-99-99");
    $('#startdate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '1d',
        endDate: '+100y',
    });

    //validate username
    $('#username').on('focusout', function() {
        if ($(this).val() != "") {
            $('#username').parsley().removeError('forcederror', {updateClass: true});
            $.ajax({
                type: "GET",
                url: "/json/validate-username",
                data: { inputUsername: $('#username').val(), },
                dataType: "json",
                success: function(data) {
                    $('#username').parsley().removeError('forcederror', {updateClass: true});
                },
                error: function(data) {
                    if (data.responseJSON == "SAME USERNAME") {
                        $('#username').parsley().addError('forcederror', {
                            message: 'Username already exist.',
                            updateClass: true,
                        });
                    }
                },
            });
        }
    });
    //validate update username
    $('#updateusername').on('focusout', function() {
        if ($(this).val() != "") {
            $('#updateusername').parsley().removeError('forcederror', {updateClass: true});
            $.ajax({
                type: "GET",
                url: "/json/validate-username",
                data: { inputUsername: $('#updateusername').val(), },
                dataType: "json",
                success: function(data) {
                    $('#updateusername').parsley().removeError('forcederror', {updateClass: true});
                },
                error: function(data) {
                    if (data.responseJSON == "SAME USERNAME") {
                        $('#updateusername').parsley().addError('forcederror', {
                            message: 'Username already exist.',
                            updateClass: true,
                        });
                    }
                },
            });
        }
    });

    //validate password
    $('.input-password').on('keyup', function() {
        if ($('#confirmpassword').val() != "") {
            $('#password').parsley().removeError('forcederror', {updateClass: true});
            $('#confirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#password').val() != $('#confirmpassword').val()) {
                $('#password').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#confirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });
    $('.input-confirmpassword').on('keyup', function() {
        if ($('#password').val() != "") {
            $('#password').parsley().removeError('forcederror', {updateClass: true});
            $('#confirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#password').val() != $('#confirmpassword').val()) {
                $('#password').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#confirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });
    //validate update password
    $('.input-updatepassword').on('keyup', function() {
        if ($('#updateconfirmpassword').val() != "") {
            $('#updatepassword').parsley().removeError('forcederror', {updateClass: true});
            $('#updateconfirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#updatepassword').val() != $('#updateconfirmpassword').val()) {
                $('#updatepassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#updateconfirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });
    $('.input-updateconfirmpassword').on('keyup', function() {
        if ($('#updatepassword').val() != "") {
            $('#updatepassword').parsley().removeError('forcederror', {updateClass: true});
            $('#updateconfirmpassword').parsley().removeError('forcederror', {updateClass: true});
            if ($('#updatepassword').val() != $('#updateconfirmpassword').val()) {
                $('#updatepassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
                $('#updateconfirmpassword').parsley().addError('forcederror', {
                    message: 'Password mismatch.',
                    updateClass: true,
                });
            }
        }
    });

    //contact person no.
    $('#contactpersonno').on('focus', function() {
        $(this).popover({
            trigger: 'manual',
            content: function() {
                var content = '<button type="button" id="comcontactpersonmn" class="btn btn-primary">Mobile No.</button>' +
                    '<button type="button" id="comcontactpersontn" class="btn btn-primary">Telephone No.</button>';
                return content;
            },
            html: true,
            placement: function() {
                var placement = 'top';
                return placement;
            },
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3>' +
                '<div class="popover-content"></div></div>',
            title: function() {
                var title = 'Choose a format:';
                return title;
            }
        });
        $(this).popover('show');
    });
    $('#contactpersonno').on('focusout', function() {
        $(this).popover('hide');
    });
    $(document).on('click', '#comcontactpersonmn', function(e) {
        $('#contactpersonno').val('');
        $('#contactpersonno').inputmask("+63 999 9999 999");
    });
    $(document).on('click', '#comcontactpersontn', function(e) {
        $('#contactpersonno').val('');
        $('#contactpersonno').inputmask("(99) 999 9999");
    });
    $('#contactpersonno').inputmask("+63 999 9999 999");
    //company contact no.
    $('#companycontactno').on('focus', function() {
        $(this).popover({
            trigger: 'manual',
            content: function() {
                var content = '<button type="button" id="comcontactmn" class="btn btn-primary">Mobile No.</button>' +
                    '<button type="button" id="comcontacttn" class="btn btn-primary">Telephone No.</button>';
                return content;
            },
            html: true,
            placement: function() {
                var placement = 'top';
                return placement;
            },
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3>' +
                '<div class="popover-content"></div></div>',
            title: function() {
                var title = 'Choose a format:';
                return title;
            }
        });
        $(this).popover('show');
    });
    $('#companycontactno').on('focusout', function() {
        $(this).popover('hide');
    });
    $(document).on('click', '#comcontactmn', function(e) {
        $('#companycontactno').val('');
        $('#companycontactno').inputmask("+63 999 9999 999");
    });
    $(document).on('click', '#comcontacttn', function(e) {
        $('#companycontactno').val('');
        $('#companycontactno').inputmask("(99) 999 9999");
    });
    $('#companycontactno').inputmask("+63 999 9999 999");
    //update contact person no.
    $('#updatecontactpersonno').on('focus', function() {
        $(this).popover({
            trigger: 'manual',
            content: function() {
                var content = '<button type="button" id="comcontactpersonmn" class="btn btn-primary">Mobile No.</button>' +
                    '<button type="button" id="comcontactpersontn" class="btn btn-primary">Telephone No.</button>';
                return content;
            },
            html: true,
            placement: function() {
                var placement = 'top';
                return placement;
            },
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3>' +
                '<div class="popover-content"></div></div>',
            title: function() {
                var title = 'Choose a format:';
                return title;
            }
        });
        $(this).popover('show');
    });
    $('#updatecontactpersonno').on('focusout', function() {
        $(this).popover('hide');
    });
    $(document).on('click', '#comcontactpersonmn', function(e) {
        $('#updatecontactpersonno').val('');
        $('#updatecontactpersonno').inputmask("+63 999 9999 999");
    });
    $(document).on('click', '#comcontactpersontn', function(e) {
        $('#updatecontactpersonno').val('');
        $('#updatecontactpersonno').inputmask("(99) 999 9999");
    });
    //update company contact no.
    $('#updatecompanycontactno').on('focus', function() {
        $(this).popover({
            trigger: 'manual',
            content: function() {
                var content = '<button type="button" id="comcontactmn" class="btn btn-primary">Mobile No.</button>' +
                    '<button type="button" id="comcontacttn" class="btn btn-primary">Telephone No.</button>';
                return content;
            },
            html: true,
            placement: function() {
                var placement = 'top';
                return placement;
            },
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3>' +
                '<div class="popover-content"></div></div>',
            title: function() {
                var title = 'Choose a format:';
                return title;
            }
        });
        $(this).popover('show');
    });
    $('#updatecompanycontactno').on('focusout', function() {
        $(this).popover('hide');
    });
    $(document).on('click', '#comcontactmn', function(e) {
        $('#updatecompanycontactno').val('');
        $('#updatecompanycontactno').inputmask("+63 999 9999 999");
    });
    $(document).on('click', '#comcontacttn', function(e) {
        $('#updatecompanycontactno').val('');
        $('#updatecompanycontactno').inputmask("(99) 999 9999");
    });

    //contract price
    $('#inputPrice').inputmask("currency", {
        alias: "currency",
        prefix: '',
        radixPoint: '.',
        allowMinus: false,
    });

    //new client
    $('#btnNew').click(function(e) {
        $('#formClient').trigger('reset');
        $('#formClient').parsley().reset();

        $('#modalClient').modal('show');
    });

    //save client info
    $('#btnClientSubmit').click(function(e) {
        if ($('#formClient').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalClient').loading({
                message: "SAVING..."
            });

            var check = false;
            if ($('#password').val() != $('#confirmpassword').val()) {
                toastr.error("PASSWORD MISMATCH");
                check = true;
            }
            if (!$('#companycontactno').inputmask('isComplete')) {
                toastr.error("INVALID COMPANY CONTACT #");
                check = true;
            }
            if (!$('#contactpersonno').inputmask('isComplete')) {
                toastr.error("INVALID CONTACT PERSON #");
                check = true;
            }
            if (check) {
                $('#modalClient').loading('stop');
                return;
            }

            var formData = {
                inputLastName: $('#lastname').val(),
                inputFirstName: $('#firstname').val(),
                inputMiddleName: $('#middlename').val(),
                inputPosition: $('#position').val(),
                inputContactPersonNo: $('#contactpersonno').val(),
                inputUsername: $('#username').val(),
                inputPassword: $('#password').val(),
                inputCompanyName: $('#companyname').val(),
                inputCompanyAddress: $('#companyaddress').val(),
                inputCompanyContactNo: $('#companycontactno').val(),
                inputCompanyEmail: $('#companyemail').val(),
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/client/new",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    if (data.middlename == null) {
                        data.middlename = "";
                    }

                    var row = "<tr id=id" + data.clientid + ">" +
                        "<td>" + data.company + "</td>" +
                        "<td>" + data.address + "</td>" +
                        "<td>" + data.companycontactno + "</td>" +
                        "<td>" + data.lastname + ", " + data.firstname + " " + data.middlename + "</td>" +
                        "<td>" + data.contactpersonno + "</td>" +
                        "<td>" + data.email + "</td>" +
                        "<td style='text-align: center;'>NO DEPLOYMENT SITE</td>" +
                        "<td style='text-align: center;'>" +
                        "<button class='btn btn-primary btn-xs' id='btnNewContract' value="+data.clientid+">New Contract</button> " +
                        "<button class='btn btn-primary btn-xs' id='btnUpdate' value="+data.clientid+">Update</button>" +
                        "</td>" +
                        "</tr>";
                    table.row.add($(row)[0]).draw();

                    $('#modalClient').modal('hide');
                    $('#modalClient').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalClient').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("CLIENT ALREADY EXIST");
                    } else if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXIST");
                    }
                }
            });
        }
    });

    //update client
    $('#client-list').on('click', '#btnUpdate', function(e) {
        $('#formCompanyDetails').trigger('reset');
        $('#formCompanyDetails').parsley().reset();
        $('#formClientInformation').trigger('reset');
        $('#formClientInformation').parsley().reset();
        $('#formAccountInformation').trigger('reset');
        $('#formAccountInformation').parsley().reset();
        clientid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/client/one",
            data: { inputClientID: clientid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                if (data.middlename == null) {
                    data.middlename = "";
                }
                if (data.contactpersonno.charAt(0) == "+") {
                    $('#updatecontactpersonno').inputmask("+63 999 9999 999");
                } else {
                    $('#updatecontactpersonno').inputmask("(99) 999 9999");
                }
                if (data.companycontactno.charAt(0) == "+") {
                    $('#updatecompanycontactno').inputmask("+63 999 9999 999");
                } else {
                    $('#updatecompanycontactno').inputmask("(99) 999 9999");
                }

                $('#pictureview').attr('src', '/client/' + data.picture);
                $('#updatelastname').val(data.lastname);
                $('#updatefirstname').val(data.firstname);
                $('#updatemiddlename').val(data.middlename);
                $('#updateposition').val(data.position);
                $('#updatecontactpersonno').val(data.contactpersonno);
                $('#updatecompanyname').val(data.company);
                $('#updatecompanyaddress').val(data.address);
                $('#updatecompanycontactno').val(data.companycontactno);
                $('#updatecompanyemail').val(data.email);

                $('#modalUpdateClient').modal('show');
            }
        });
    });

    //company details save
    $('#btnCompanyDetailsSave').click(function(e) {
        if ($('#formCompanyDetails').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalUpdateClient').loading({
                message: "SAVING...",
            });

            if (!$('#updatecompanycontactno').inputmask('isComplete')) {
                toastr.error("INVALID CONTACT #");
                $('#modalUpdateClient').loading('stop');
                return;
            }

            var formData = {
                inputClientID: clientid,
                inputCompanyName: $('#updatecompanyname').val(),
                inputCompanyAddress: $('#updatecompanyaddress').val(),
                inputCompanyContactNo: $('#updatecompanycontactno').val(),
                inputCompanyEmail: $('#updatecompanyemail').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/client/companydetail",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        $('#updatecompanyname').val(),
                        $('#updatecompanyaddress').val(),
                        $('#updatecompanycontactno').val(),
                        table.row('#id' + clientid).data()[3],
                        table.row('#id' + clientid).data()[4],
                        $('#updatecompanyemail').val(),
                        table.row('#id' + clientid).data()[6],
                        table.row('#id' + clientid).data()[7],
                    ];
                    table.row('#id' + clientid).data(dt).draw(false);

                    $('#formCompanyDetails').parsley().reset();
                    $('#modalUpdateClient').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalUpdateClient').loading('stop');
                    if (data.responseJSON == "SAME NAME") {
                        toastr.error("CLIENT ALREADY EXIST");
                    }
                }
            })
        }
    });

    //client information save
    $('#btnClientInformationSave').click(function(e) {
        if ($('#formClientInformation').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalUpdateClient').loading({
                message: "SAVING...",
            });

            if (!$('#updatecontactpersonno').inputmask('isComplete')) {
                toastr.error("INVALID CONTACT #");
                $('#modalUpdateClient').loading('stop');
                return;
            }

            var formData = {
                inputClientID: clientid,
                inputLastName: $('#updatelastname').val(),
                inputFirstName: $('#updatefirstname').val(),
                inputMiddleName: $('#updatemiddlename').val(),
                inputPosition: $('#updateposition').val(),
                inputContactPersonNo: $('#updatecontactpersonno').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/client/clientinformation",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    var dt = [
                        table.row('#id' + clientid).data()[0],
                        table.row('#id' + clientid).data()[1],
                        table.row('#id' + clientid).data()[2],
                        $('#updatelastname').val() + ", " + $('#updatefirstname').val() + " " + $('#updatemiddlename').val(),
                        $('#updatecontactpersonno').val(),
                        table.row('#id' + clientid).data()[5],
                        table.row('#id' + clientid).data()[6],
                        table.row('#id' + clientid).data()[7],
                    ];
                    table.row('#id' + clientid).data(dt).draw(false);

                    $('#formClientInformation').parsley().reset();
                    $('#modalUpdateClient').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalUpdateClient').loading('stop');
                }
            })
        }
    });

    //account information save
    $('#btnAccountInformationSave').click(function(e) {
        if ($('#formAccountInformation').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalUpdateClient').loading({
                message: "SAVING...",
            });

            if ($('#updatepassword').val() != $('#updateconfirmpassword').val()) {
                toastr.error("PASSWORD MISMATCH");
                $('#modalUpdateClient').loading('stop');
                return;
            }

            var formData = {
                inputClientID: clientid,
                inputUsername: $('#updateusername').val(),
                inputPassword: $('#updatepassword').val()
            };

            $.ajax({
                type: "POST",
                url: "/admin/transaction/client/accountinformation",
                data: formData,
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    $('#formAccountInformation').parsley().reset();
                    $('#modalUpdateClient').loading('stop');
                    toastr.success("SAVE SUCCESSFUL");
                },
                error: function(data) {
                    console.log(data);

                    $('#modalUpdateClient').loading('stop');
                    if (data.responseJSON == "SAME USERNAME") {
                        toastr.error("USERNAME ALREADY EXIST");
                    }
                }
            })
        }
    });

    //profile image save
    $('#btnSaveImage').click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            toastr.error("INVALID IMAGE INPUT");
            return;
        }
        
        $('#modalUpdateClient').loading({
            message: "SAVING..."
        });

        var image = $('#picture')[0].files[0];
        var form = new FormData();

        form.append('clientid', clientid);
        form.append('image', image);

        $.ajax({
            type: "POST",
            url: "/admin/transaction/client/profileimage",
            data: form,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {

                $('#formImage').trigger('reset');
                $('#modalUpdateClient').loading('stop');
                toastr.success("SAVE SUCCESSFUL");
            }
        });
    });

    //new contract
    $('#client-list').on('click', '#btnNewContract', function(e) {
        $('#formContract').trigger('reset');
        $('#formContract').parsley().reset();
        clientid = $(this).val();

        $('#modalContract').modal('show');
    });

    //saving of contract
    $('#btnContractSubmit').click(function(e) {
        if ($('#formContract').parsley().isValid()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $('#modalContract').loading({
                message: "SAVING..."
            });
            adminid = $('meta[name="AuthenticatedID"]').attr('content');

            if ($('#inputPrice').val() == 0) {
                toastr.error("INVALID CONTRACT PRICE");
                $('#modalContract').loading('stop');
                return;
            }

            var online = navigator.onLine;
            if (online) {
                var geocoder = new google.maps.Geocoder();
                var formData = {};
                geocoder.geocode({'address': $('#inputAddress').val()+", "+$('#inputCity').val()+", "+$('#inputProvince').val()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        formData = {
                            inputAdminID: adminid,
                            inputClientID: clientid,
                            inputStartdate: $('#startdate').val(),
                            inputLength: $('#inputLength').val(),
                            inputLengthType: $('#lengthtype').val(),
                            inputPrice: $('#inputPrice').val(),
                            inputPlaceHeld: $('#inputPlaceHeld').val(),
                            inputBuildingAreaName: $('#inputBuildingAreaName').val(),
                            inputAddress: $('#inputAddress').val(),
                            inputCity: $('#inputCity').val(),
                            inputProvince: $('#inputProvince').val(),
                            inputLatitude: results[0].geometry.location.lat(),
                            inputLongitude: results[0].geometry.location.lng(),
                        };
                    } else {
                        formData = {
                            inputAdminID: adminid,
                            inputClientID: clientid,
                            inputStartdate: $('#startdate').val(),
                            inputLength: $('#inputLength').val(),
                            inputLengthType: $('#lengthtype').val(),
                            inputPrice: $('#inputPrice').val(),
                            inputPlaceHeld: $('#inputPlaceHeld').val(),
                            inputBuildingAreaName: $('#inputBuildingAreaName').val(),
                            inputAddress: $('#inputAddress').val(),
                            inputCity: $('#inputCity').val(),
                            inputProvince: $('#inputProvince').val(),
                            inputLatitude: null,
                            inputLongitude: null,
                        };
                    }

                    $.ajax({
                        type: "POST",
                        url: "/admin/transaction/client/contract/new",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            console.log(data);

                            var dt = [
                                table.row('#id' + clientid).data()[0],
                                table.row('#id' + clientid).data()[1],
                                table.row('#id' + clientid).data()[2],
                                table.row('#id' + clientid).data()[3],
                                table.row('#id' + clientid).data()[4],
                                table.row('#id' + clientid).data()[3],
                                "ACTIVE",
                                table.row('#id' + clientid).data()[7],
                            ];
                            table.row('#id' + clientid).data(dt).draw(false);

                            $('#modalContract').modal('hide');
                            $('#modalContract').loading('stop');
                            toastr.success("SAVE SUCCESSFUL");
                        },
                        error: function(data) {
                            console.log(data);

                            $('#modalContract').loading('stop');
                            if (data.responseJSON == "SAME DEPLOYMENT SITE") {
                                toastr.error("DEPLOYMENT SITE ALREADY EXIST");
                            }
                        }
                    });
                });
            } else {
                var formData = {};

                formData = {
                    inputAdminID: adminid,
                    inputClientID: clientid,
                    inputStartdate: $('#startdate').val(),
                    inputLength: $('#inputLength').val(),
                    inputLengthType: $('#lengthtype').val(),
                    inputPrice: $('#inputPrice').val(),
                    inputPlaceHeld: $('#inputPlaceHeld').val(),
                    inputBuildingAreaName: $('#inputBuildingAreaName').val(),
                    inputAddress: $('#inputAddress').val(),
                    inputCity: $('#inputCity').val(),
                    inputProvince: $('#inputProvince').val(),
                    inputLatitude: null,
                    inputLongitude: null,
                };

                $.ajax({
                    type: "POST",
                    url: "/admin/transaction/client/contract/new",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);

                        $('#modalContract').modal('hide');
                        $('#modalContract').loading('stop');
                        toastr.success("SAVE SUCCESSFUL");
                    },
                    error: function(data) {
                        console.log(data);

                        $('#modalContract').loading('stop');
                        if (data.responseJSON == "SAME DEPLOYMENT SITE") {
                            toastr.error("DEPLOYMENT SITE ALREADY EXIST");
                        }
                    }
                });
            }
        }
    });



});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#pictureview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        $('#pictureview').attr('src', '/images/default.png');
    }
}
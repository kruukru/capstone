$(document).ready(function() {
    var applicantid, qid;

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
    $('#cityaddressprovince').on('change', function(e) {
        $('#cityaddresscity').empty();
        $('#cityaddresscity').append('<option></option');
        if ($(this).val() == 'Abra') {
            jQuery.each(abra, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Agusan Del Norte') {
            jQuery.each(agusandelnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Agusan Del Sur') {
            jQuery.each(agusandelsur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Aklan') {
            jQuery.each(aklan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Albay') {
            jQuery.each(albay, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Antique') {
            jQuery.each(antique, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Apayao') {
            jQuery.each(apayao, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Aurora') {
            jQuery.each(aurora, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Basilan') {
            jQuery.each(basilan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bataan') {
            jQuery.each(bataan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Batanes') {
            jQuery.each(batanes, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Batangas') {
            jQuery.each(batangas, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Benguet') {
            jQuery.each(benguet, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Biliran') {
            jQuery.each(biliran, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bohol') {
            jQuery.each(bohol, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bulacan') {
            jQuery.each(bulacan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bukidnon') {
            jQuery.each(bukidnon, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cagayan') {
            jQuery.each(cagayan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camarines Norte') {
            jQuery.each(camarinesnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camarines Sur') {
            jQuery.each(camarinessur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camiguin') {
            jQuery.each(camiguin, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Capiz') {
            jQuery.each(capiz, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Catanduanes') {
            jQuery.each(catanduanes, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cavite') {
            jQuery.each(cavite, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cebu') {
            jQuery.each(cebu, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Compostella Valley') {
            jQuery.each(compostellavalley, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cotabato') {
            jQuery.each(cotabato, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Del Norte') {
            jQuery.each(davaodelnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Del Sur') {
            jQuery.each(davaodelsur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Occidental') {
            jQuery.each(davaooccidental, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Oriental') {
            jQuery.each(davaooriental, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Dinagat Islands') {
            jQuery.each(dinagatislands, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Eastern Samar') {
            jQuery.each(easternsamar, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Guimaras') {
            jQuery.each(guimaras, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ifugao') {
            jQuery.each(ifugao, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ilocos Norte') {
            jQuery.each(ilocosnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ilocos Sur') {
            jQuery.each(ilocossur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Iloilo') {
            jQuery.each(iloilo, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Isabela') {
            jQuery.each(isabela, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Kalinga') {
            jQuery.each(kalinga, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'La Union') {
            jQuery.each(launion, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Laguna') {
            jQuery.each(laguna, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Lanao Del Norte') {
            jQuery.each(lanaodelnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Lanao Del Sur') {
            jQuery.each(lanaodelsur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Leyte') {
            jQuery.each(leyte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Maguindanao') {
            jQuery.each(maguindanao, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Marinduque') {
            jQuery.each(marinduque, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Masbate') {
            jQuery.each(masbate, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Metro Manila') {
            jQuery.each(metromanila, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Misamis Occidental') {
            jQuery.each(misamisoccidental, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Misamis Oriental') {
            jQuery.each(misamisoriental, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Mountain Province') {
            jQuery.each(mountainprovince, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Negros Occidental') {
            jQuery.each(negrosoccidental, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Negros Oriental') {
            jQuery.each(negrosoriental, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Northern Samar') {
            jQuery.each(northernsamar, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Neuva Ecija') {
            jQuery.each(nuevaecija, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Nueva Vizcaya') {
            jQuery.each(nuevavizcaya, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Occidental Mindoro') {
            jQuery.each(occidentalmindoro, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Oriental Mindoro') {
            jQuery.each(orientalmindoro, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Palawan') {
            jQuery.each(palawan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Pampanga') {
            jQuery.each(pampanga, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Pangasinan') {
            jQuery.each(pangasinan, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Quezon') {
            jQuery.each(quezon, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Quirino') {
            jQuery.each(quirino, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Rizal') {
            jQuery.each(rizal, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Romblon') {
            jQuery.each(romblon, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Samar') {
            jQuery.each(samar, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sarangani') {
            jQuery.each(sarangani, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Siquijor') {
            jQuery.each(siquijor, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sorsogon') {
            jQuery.each(sorsogon, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'South Cotabato') {
            jQuery.each(southcotabato, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Southern Leyte') {
            jQuery.each(southernleyte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sultan Kudarat') {
            jQuery.each(sultankudarat, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sulu') {
            jQuery.each(sulu, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Surigao Del Norte') {
            jQuery.each(surigaodelnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Surigao Del Sur') {
            jQuery.each(surigaodelsur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Tarlac') {
            jQuery.each(tarlac, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Tawi-Tawi') {
            jQuery.each(tawitawi, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zambales') {
            jQuery.each(zambales, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Del Norte') {
            jQuery.each(zamboangadelnorte, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Del Sur') {
            jQuery.each(zambaongadelsur, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Sibugay') {
            jQuery.each(zamboangasibugay, function(index, item) {
                $('#cityaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        }
    });

    //province address
    $('#provincialaddressprovince').on('change', function(e) {
        $('#provincialaddresscity').empty();
        $('#provincialaddresscity').append('<option></option');
        if ($(this).val() == 'Abra') {
            jQuery.each(abra, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Agusan Del Norte') {
            jQuery.each(agusandelnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Agusan Del Sur') {
            jQuery.each(agusandelsur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Aklan') {
            jQuery.each(aklan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Albay') {
            jQuery.each(albay, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Antique') {
            jQuery.each(antique, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Apayao') {
            jQuery.each(apayao, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Aurora') {
            jQuery.each(aurora, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Basilan') {
            jQuery.each(basilan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bataan') {
            jQuery.each(bataan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Batanes') {
            jQuery.each(batanes, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Batangas') {
            jQuery.each(batangas, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Benguet') {
            jQuery.each(benguet, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Biliran') {
            jQuery.each(biliran, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bohol') {
            jQuery.each(bohol, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bulacan') {
            jQuery.each(bulacan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Bukidnon') {
            jQuery.each(bukidnon, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cagayan') {
            jQuery.each(cagayan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camarines Norte') {
            jQuery.each(camarinesnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camarines Sur') {
            jQuery.each(camarinessur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Camiguin') {
            jQuery.each(camiguin, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Capiz') {
            jQuery.each(capiz, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Catanduanes') {
            jQuery.each(catanduanes, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cavite') {
            jQuery.each(cavite, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cebu') {
            jQuery.each(cebu, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Compostella Valley') {
            jQuery.each(compostellavalley, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Cotabato') {
            jQuery.each(cotabato, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Del Norte') {
            jQuery.each(davaodelnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Del Sur') {
            jQuery.each(davaodelsur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Occidental') {
            jQuery.each(davaooccidental, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Davao Oriental') {
            jQuery.each(davaooriental, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Dinagat Islands') {
            jQuery.each(dinagatislands, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Eastern Samar') {
            jQuery.each(easternsamar, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Guimaras') {
            jQuery.each(guimaras, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ifugao') {
            jQuery.each(ifugao, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ilocos Norte') {
            jQuery.each(ilocosnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Ilocos Sur') {
            jQuery.each(ilocossur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Iloilo') {
            jQuery.each(iloilo, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Isabela') {
            jQuery.each(isabela, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Kalinga') {
            jQuery.each(kalinga, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'La Union') {
            jQuery.each(launion, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Laguna') {
            jQuery.each(laguna, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Lanao Del Norte') {
            jQuery.each(lanaodelnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Lanao Del Sur') {
            jQuery.each(lanaodelsur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Leyte') {
            jQuery.each(leyte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Maguindanao') {
            jQuery.each(maguindanao, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Marinduque') {
            jQuery.each(marinduque, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Masbate') {
            jQuery.each(masbate, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Metro Manila') {
            jQuery.each(metromanila, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Misamis Occidental') {
            jQuery.each(misamisoccidental, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Misamis Oriental') {
            jQuery.each(misamisoriental, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Mountain Province') {
            jQuery.each(mountainprovince, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Negros Occidental') {
            jQuery.each(negrosoccidental, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Negros Oriental') {
            jQuery.each(negrosoriental, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Northern Samar') {
            jQuery.each(northernsamar, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Neuva Ecija') {
            jQuery.each(nuevaecija, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Nueva Vizcaya') {
            jQuery.each(nuevavizcaya, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Occidental Mindoro') {
            jQuery.each(occidentalmindoro, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Oriental Mindoro') {
            jQuery.each(orientalmindoro, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Palawan') {
            jQuery.each(palawan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Pampanga') {
            jQuery.each(pampanga, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Pangasinan') {
            jQuery.each(pangasinan, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Quezon') {
            jQuery.each(quezon, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Quirino') {
            jQuery.each(quirino, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Rizal') {
            jQuery.each(rizal, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Romblon') {
            jQuery.each(romblon, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Samar') {
            jQuery.each(samar, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sarangani') {
            jQuery.each(sarangani, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Siquijor') {
            jQuery.each(siquijor, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sorsogon') {
            jQuery.each(sorsogon, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'South Cotabato') {
            jQuery.each(southcotabato, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Southern Leyte') {
            jQuery.each(southernleyte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sultan Kudarat') {
            jQuery.each(sultankudarat, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Sulu') {
            jQuery.each(sulu, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Surigao Del Norte') {
            jQuery.each(surigaodelnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Surigao Del Sur') {
            jQuery.each(surigaodelsur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Tarlac') {
            jQuery.each(tarlac, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Tawi-Tawi') {
            jQuery.each(tawitawi, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zambales') {
            jQuery.each(zambales, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Del Norte') {
            jQuery.each(zamboangadelnorte, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Del Sur') {
            jQuery.each(zambaongadelsur, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        } else if ($(this).val() == 'Zamboanga Sibugay') {
            jQuery.each(zamboangasibugay, function(index, item) {
                $('#provincialaddresscity').append('<option value="'+item+'">'+item+'</option>');
            });
        }
    });

    var table = $('#tblApplicant').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    table.order([[1, 'asc']]).draw();
    var tableRequirement = $('#tblRequirement').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    var tablePass = $('#tblPass').DataTable({
        "aoColumns": [
            null,
            { "bSearchable": false, "bSortable": false, },
        ]
    });
    //table education background
    var tableEducationBackground = $('#tblEducationBackground').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ],
    });
    //table employee record
    var tableEmploymentRecord = $('#tblEmploymentRecord').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ],
    });
    //table training certificate
    var tableTrainingCertificate = $('#tblTrainingCertificate').DataTable({
        "aoColumns": [
            null,
            null,
            null,
            { "bSearchable": false, "bSortable": false, },
        ],
    });

    $('#modalCredential').on('hide.bs.modal', function() {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //     }
        // })

        // $.ajax({
        //     type: "POST",
        //     url: "/admin/transaction/requirement/assess",
        //     data: { inputApplicantID: applicantid, inputStatus: tableRequirement.data().count(), },
        //     dataType: "json",
        //     success: function(data) {
        //         console.log(data);

        //         if (tableRequirement.data().count() == 0) {
        //             table.row('#id' + data.applicantid).remove().draw(false);
        //         } else {
        //             var dt = [
        //                 table.cell('#id'+applicantid, 0).data(),
        //                 table.cell('#id'+applicantid, 1).data(),
        //                 table.cell('#id'+applicantid, 2).data(),
        //                 table.cell('#id'+applicantid, 3).data(),
        //                 "FOR FOLLOW UP",
        //                 table.cell('#id'+applicantid, 5).data(),
        //             ];
        //             table.row('#id' + data.applicantid).data(dt).draw(false);
        //         }

        //         tableRequirement.clear().draw();
        //         tablePass.clear().draw();
        //         toastr.success("SAVE SUCCESSFUL");
        //     },
        //     error: function(data) {
        //         console.log(data);
        //     },
        // });
    });

    //editable select industry type
    $('#erIndustryType').editableSelect({
        effects: 'slide',
    });
    //editable select religion
    $('#religion').editableSelect({
        effects: 'slide',
    });

    //contact pop up
    $('#appcontactno').on('focus', function() {
        $(this).popover({
            trigger: 'manual',
            content: function() {
                var content = '<button type="button" id="appcontactnomn" class="btn btn-primary">Mobile No.</button>' +
                    '<button type="button" id="appcontactnotn" class="btn btn-primary">Telephone No.</button>';
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
    $('#appcontactno').on('focusout', function() {
        $(this).popover('hide');
    });
    $(document).on('click', '#appcontactnomn', function(e) {
        $('#appcontactno').val('');
        $('#appcontactno').inputmask("+63 999 9999 999");
    });
    $(document).on('click', '#appcontactnotn', function(e) {
        $('#appcontactno').val('');
        $('#appcontactno').inputmask("(99) 999 9999");
    });

    //date picker
    $('.mydatepicker').change(function() {
        $(this).parsley().validate();
    });
    $('#dateofbirth').change(function() {
        $('#age').val(getAge($('#dateofbirth').val()));
    });
    $('#dateofbirth').inputmask("9999-99-99");
    $('#dateofbirth').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '-100y',
        endDate: '-18y',
    });
    $('#spousebirthdate').inputmask("9999-99-99");
    $('#spousebirthdate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '-100y',
        endDate: '-18y',
    });
    $('#licenseexpiration').inputmask("9999-99-99");
    $('#licenseexpiration').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '1d',
        endDate: '+100y',
    });
    $('#ebDateGraduated').inputmask("9999-99-99");
    $('#ebDateGraduated').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '-100y',
        endDate: '-1d',
    });
    $('#tcDateConducted').inputmask("9999-99-99");
    $('#tcDateConducted').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: '-100y',
        endDate: '-1d',
    });

    //spouse show and hide
    $('#civilstatus').on('change', function() {
        if ($(this).val() == "Single") {
            $('.spouse-info').hide();
            $('#spousename').val("");
            $('#spousebirthdate').val("");
            $('#spouseoccupation').val("");
        } else {
            $('.spouse-info').show();
        }
    });
    //degree show and hide
    $('#ebGraduateType').on('change', function() {
        if ($(this).val() == "College" || $(this).val() == "Vocational") {
            $('.degree-info').show();
        } else {
            $('.degree-info').hide();
            $('#ebDegree').val("");
        }
    })

    //icheck
    $('input').iCheck({
        radioClass: 'iradio_flat-blue',
    });

    //update the picture in the img source
    $("#picture").change(function() {
        readURL(this);
    });

    //validate if the picture is an image
    $('#btnImageSave').click(function(e) {
        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            e.preventDefault();

            toastr.error("INVALID IMAGE INPUT");
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
    })

    $('#applicant-list').on('click', '#btnAssess', function(e) {
        e.preventDefault();
        resetModalCredential();
        applicantid = $(this).val();

        $.ajax({
            type: "GET",
            url: "/json/applicant/one",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('#lastname').val(data.lastname);
                $('#firstname').val(data.firstname);
                $('#middlename').val(data.middlename);
                $('#suffix').val(data.suffix);
                $('#dateofbirth').val($.format.date(data.dateofbirth, "yyyy-MM-dd"));
                $('#age').val(data.age);
                $('#placeofbirth').val(data.placeofbirth);
                $('#appcontactno').val(data.appcontactno);
                if (data.gender == "Male") {
                    $('#gender[value="Male"]').prop('checked', true).iCheck('update');
                    $('#gender[value="Female"]').prop('checked', false).iCheck('update');
                } else {
                    $('#gender[value="Male"]').prop('checked', false).iCheck('update');
                    $('#gender[value="Female"]').prop('checked', true).iCheck('update');
                }
                $('#civilstatus').val(data.civilstatus);
                $('#religion').val(data.religion);
                $('#height').val(data.height);
                $('#weight').val(data.weight);
                $('#bloodtype').val(data.bloodtype);
                $('#cityaddress').val(data.cityaddress);
                $('#provincialaddress').val(data.provincialaddress);
                $('#hobby').val(data.hobby);
                $('#skill').val(data.skill);
                $('#license').val(data.license);
                $('#licenseexpiration').val($.format.date(data.licenseexpiration, "yyyy-MM-dd"));
                $('#sss').val(data.sss);
                $('#philhealth').val(data.philhealth);
                $('#pagibig').val(data.pagibig);
                $('#tin').val(data.tin);
                $('#contactperson').val(data.contactperson);
                $('#contactno').val(data.contactno);
                $('#contacttelno').val(data.contacttelno);
                if (data.civilstatus == "Single") {
                    $('.spouse-info').hide();
                    $('#spousename').val("");
                    $('#spousebirthdate').val("");
                    $('#spouseoccupation').val("");
                } else {
                    $('.spouse-info').show();
                    $('#spousename').val(data.spousename);
                    $('#spousebirthdate').val(data.spousedateofbirth);
                    $('#spouseoccupation').val(data.spouseoccupation);
                }
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/transaction/applicantrequirement",
            data: { inputApplicantID: applicantid },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $.each(data, function(index, value) {
                    if (value.issubmitted == 0) {
                        var row = "<tr id=out" + value.applicantrequirementid + ">" +
                            "<td>" + value.requirement.name + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-primary btn-xs' id='btnPass' value="+value.applicantrequirementid+">Submit</button> " +
                            "</td>" +
                            "</tr>";
                        tableRequirement.row.add($(row)[0]).draw();
                    } else {
                        var row = "<tr id=in" + value.applicantrequirementid + ">" +
                            "<td>" + value.requirement.name + "</td>" +
                            "<td style='text-align: center;'>" +
                            "<button class='btn btn-danger btn-xs' id='btnRemove' value="+value.applicantrequirementid+">Remove</button> " +
                            "</td>" +
                            "</tr>";
                        tablePass.row.add($(row)[0]).draw();
                    }
                });
            },
        });

        $('#modalCredential').modal('show');
    });

    //personal information info
     $('#btnPersonalInformationSave').click(function(e) {
        if ($('#formPersonalInformation').parsley().validate()) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var online = navigator.onLine;
            if (online) {
                var geocoder = new google.maps.Geocoder();
                var formData = {};
                geocoder.geocode({'address': $('#cityaddress').val()+", "+$('#cityaddresscity').val()+", "+$('#cityaddressprovince').val()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        formData = {
                            inputApplicantID: applicantid,
                            inputLastname: $('#lastname').val(),
                            inputFirstname: $('#firstname').val(),
                            inputMiddlename: $('#middlename').val(),
                            inputSuffix: $('#suffix').val(),
                            inputCityAddress: $('#cityaddress').val(),
                            inputCityAddressProvince: $('#cityaddressprovince').val(),
                            inputCityAddressCity: $('#cityaddresscity').val(),
                            inputProvincialAddress: $('#provincialaddress').val(),
                            inputProvincialAddressProvince: $('#inputprovincialaddressprovince').val(),
                            inputProvincialAddressCity: $('#inputprovincialaddresscity').val(),
                            inputLatitude: results[0].geometry.location.lat(),
                            inputLongitude: results[0].geometry.location.lng(),
                            inputGender: $('input:radio[name="gender"]:checked').val(),
                            inputDateOfBirth: $('#dateofbirth').val(),
                            inputPlaceOfBirth: $('#placeofbirth').val(),
                            inputAge: $('#age').val(),
                            inputCivilStatus: $('#civilstatus').val(),
                            inputReligion: $('#religion').val(),
                            inputBloodType: $('#bloodtype').val(),
                            inputAppContactNo: $('#appcontactno').val(),
                            inputHeight: height,
                            inputWeight: weight,
                        }
                    } else {
                        formData = {
                            inputApplicantID: applicantid,
                            inputLastname: $('#lastname').val(),
                            inputFirstname: $('#firstname').val(),
                            inputMiddlename: $('#middlename').val(),
                            inputSuffix: $('#suffix').val(),
                            inputCityAddress: $('#cityaddress').val(),
                            inputCityAddressProvince: $('#cityaddressprovince').val(),
                            inputCityAddressCity: $('#cityaddresscity').val(),
                            inputProvincialAddress: $('#provincialaddress').val(),
                            inputProvincialAddressProvince: $('#inputprovincialaddressprovince').val(),
                            inputProvincialAddressCity: $('#inputprovincialaddresscity').val(),
                            inputLatitude: results[0].geometry.location.lat(),
                            inputLongitude: results[0].geometry.location.lng(),
                            inputGender: $('input:radio[name="gender"]:checked').val(),
                            inputDateOfBirth: $('#dateofbirth').val(),
                            inputPlaceOfBirth: $('#placeofbirth').val(),
                            inputAge: $('#age').val(),
                            inputCivilStatus: $('#civilstatus').val(),
                            inputReligion: $('#religion').val(),
                            inputBloodType: $('#bloodtype').val(),
                            inputAppContactNo: $('#appcontactno').val(),
                            inputHeight: height,
                            inputWeight: weight,
                        }
                    }

                    $.ajax({
                        type: "POST",
                        url: "/admin/transaction/applicantinfo/personalinfo",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            console.log(data);


                        },
                    });
                });
            } else {
                var formData = {};
                formData = {
                    inputApplicantID: applicantid,
                    inputLastname: $('#lastname').val(),
                    inputFirstname: $('#firstname').val(),
                    inputMiddlename: $('#middlename').val(),
                    inputSuffix: $('#suffix').val(),
                    inputCityAddress: $('#cityaddress').val(),
                    inputCityAddressProvince: $('#cityaddressprovince').val(),
                    inputCityAddressCity: $('#cityaddresscity').val(),
                    inputProvincialAddress: $('#provincialaddress').val(),
                    inputProvincialAddressProvince: $('#inputprovincialaddressprovince').val(),
                    inputProvincialAddressCity: $('#inputprovincialaddresscity').val(),
                    inputLatitude: results[0].geometry.location.lat(),
                    inputLongitude: results[0].geometry.location.lng(),
                    inputGender: $('input:radio[name="gender"]:checked').val(),
                    inputDateOfBirth: $('#dateofbirth').val(),
                    inputPlaceOfBirth: $('#placeofbirth').val(),
                    inputAge: $('#age').val(),
                    inputCivilStatus: $('#civilstatus').val(),
                    inputReligion: $('#religion').val(),
                    inputBloodType: $('#bloodtype').val(),
                    inputAppContactNo: $('#appcontactno').val(),
                    inputHeight: height,
                    inputWeight: weight,
                }

                $.ajax({
                    type: "POST",
                    url: "/admin/transaction/applicantinfo/personalinfo",
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);


                    },
                });
            }
        }
    });

    //pass a requirement
    $('#requirement-list').on('click', '#btnPass', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var qid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/admin/transaction/requirement/pass",
            data: { inputApplicantRequirementID: qid, inputApplicantID: applicantid, },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
                var row = "<tr id=in"+data.applicantrequirementid+">" +
                    "<td>" + data.requirement.name + "</td>" +
                    "<td style='text-align: center;'>" +
                    "<button class='btn btn-danger btn-xs' id='btnRemove' value="+data.applicantrequirementid+">Remove</button> " +
                    "</td>" +
                    "</tr>";

                tablePass.row.add($(row)[0]).draw();
                tableRequirement.row('#out' + qid).remove().draw(false);
            },
        });
    });

    //remove a requirement
    $('#pass-list').on('click', '#btnRemove', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var qid = $(this).val();

        $.ajax({
            type: "POST",
            url: "/admin/transaction/requirement/remove",
            data: { inputApplicantRequirementID: qid, inputApplicantID: applicantid, },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
                var row = "<tr id=out"+data.applicantrequirementid+">" +
                    "<td>" + data.requirement.name + "</td>" +
                    "<td style='text-align: center;'>" +
                    "<button class='btn btn-primary btn-xs' id='btnPass' value="+data.applicantrequirementid+">Submit</button> " +
                    "</td>" +
                    "</tr>";

                tableRequirement.row.add($(row)[0]).draw();
                tablePass.row("#in" + qid).remove().draw(false);
            },
        });
    });

    function resetModalCredential() {
        $('#formPersonalInformation').trigger('reset');
        $('#formPersonalInformation').parsley().reset();
        $('#formImage').trigger('reset');
        $('#formImage').parsley().reset();
        $('#formAccount').trigger('reset');
        $('#formAccount').parsley().reset();
        $('#formIDs').trigger('reset');
        $('#formIDs').parsley().reset();
        $('#formEducationBackground').trigger('reset');
        $('#formEducationBackground').parsley().reset();
        $('#formEmploymentRecord').trigger('reset');
        $('#formEmploymentRecord').parsley().reset();
        $('#formTrainingCertificate').trigger('reset');
        $('#formTrainingCertificate').parsley().reset();
        tableRequirement.clear().draw();
        tablePass.clear().draw();
        tableEducationBackground.clear().draw();
        tableEmploymentRecord.clear().draw();
        tableTrainingCertificate.clear().draw();
    }

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

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
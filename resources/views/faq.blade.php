<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Audra Haven Suites & Residences</title>

    {{-- Font Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #333;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar Styles */
        .navbar {
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 50;
            height: 96px;
        }
        .nav-link {
            font-size: 14px;
            font-weight: 600;
            color: #2d2317;
            text-decoration: none;
            margin: 0 15px;
            transition: color 0.2s;
        }
        .nav-link:hover { color: #b8935a; }

        /* FAQ Accordion Styles (Murni CSS) */
        details {
            background-color: #d1d5db; /* Warna abu-abu seperti The Wujil */
            margin-bottom: 20px;
            border-radius: 2px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        details[open] {
            background-color: #e5e7eb; /* Sedikit lebih terang saat terbuka */
        }

        summary {
            padding: 25px 30px;
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            cursor: pointer;
            list-style: none; /* Menghilangkan panah bawaan browser */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Menghilangkan panah bawaan di Safari */
        summary::-webkit-details-marker {
            display: none;
        }

        /* Menghilangkan ikon panah sepenuhnya */
        summary::after {
            content: ''; 
        }

        .faq-answer {
            padding: 0 30px 25px 30px;
            color: #4b5563;
            font-size: 15px;
            line-height: 1.7;
        }
    </style>
</head>
<body>

    <!-- Navbar Publik -->
    <header class="navbar">
        <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logoPutih.png') }}" alt="Audra Haven" class="h-16 w-auto object-contain">
            </a>

            <nav class="hidden lg:flex items-center">
                <a href="/#kamar" class="nav-link">Rooms & Suites</a>
                <a href="#" class="nav-link">Restaurant & Cafe</a>
                <a href="#" class="nav-link">Weddings & Events</a>
                <a href="#" class="nav-link">Facilities</a>
                <a href="#" class="nav-link">Special Offers</a>
                <a href="{{ url('/faq') }}" class="nav-link text-[#b8935a]">FAQ</a>
            </nav>

            <div class="flex items-center gap-5">
                <a href="{{ route('login') }}" class="bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-3 px-6 rounded transition" style="font-size: 13px;">
                    BOOK NOW
                </a>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="max-w-6xl mx-auto px-6 py-8">
        <div class="text-sm text-gray-500">
            <a href="/" class="hover:text-[#b8935a] transition">Home</a> 
            <span class="mx-2">&bull;</span> 
            <span class="text-gray-400">FAQ</span>
        </div>
    </div>

    <!-- Judul Halaman -->
    <div class="text-center mb-12 px-6">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800">
            Official FAQ Audra Haven
        </h1>
    </div>

    <!-- Daftar FAQ -->
    <div class="max-w-6xl mx-auto px-6 pb-24">
        
        <!-- FAQ 1 -->
        <details>
            <summary>Does Audra Haven Suites & Residences offer a best price guarantee?</summary>
            <div class="faq-answer">
                Yes, we do. When you book directly through our official website, we guarantee you will get the best available rate. If you find a lower rate on another website, we will match it.
            </div>
        </details>

        <!-- FAQ 2 -->
        <details>
            <summary>How can I contact Audra Haven Suites & Residences?</summary>
            <div class="faq-answer">
                You can reach us via phone at +62 24 123-4567, WhatsApp at +62 812 3456 7890, or email us at info@audrahaven.com. Our reservations team is available 24/7.
            </div>
        </details>

        <!-- FAQ 3 -->
        <details>
            <summary>I am part of a group/event scheduled at Audra Haven, how do I book a room?</summary>
            <div class="faq-answer">
                Please contact our sales and events team directly. Provide them with the name of your event, and they will assist you with room reservations under the special group block rate.
            </div>
        </details>

        <!-- FAQ 4 -->
        <details>
            <summary>How many rooms are there at Audra Haven Suites & Residences?</summary>
            <div class="faq-answer">
                Audra Haven features a total of 25 elegantly designed rooms and suites, ranging from our cozy Deluxe Rooms to the luxurious Presidential Residence.
            </div>
        </details>

        <!-- FAQ 5 -->
        <details>
            <summary>Is there a restaurant at Audra Haven Suites & Residences?</summary>
            <div class="faq-answer">
                Yes, we have multiple dining options. Enjoy our signature local and international dishes at our main restaurant, relax with a drink at our lounge, or take a dip and enjoy light bites at the pool bar.
            </div>
        </details>

        <!-- FAQ 6 -->
        <details>
            <summary>Does the hotel provide meeting rooms?</summary>
            <div class="faq-answer">
                Absolutely. We offer several versatile venues, including our Grand Ballroom and smaller meeting rooms, equipped with modern audio-visual technology and high-speed Wi-Fi, perfect for corporate events and weddings.
            </div>
        </details>

        <!-- FAQ 7 -->
        <details>
            <summary>What are the bed sizes in the rooms?</summary>
            <div class="faq-answer">
                Our rooms offer various bedding configurations. Deluxe and Premier Rooms feature a King size bed or two Twin beds. Our suites include a larger King bed, and our Family Suites come with a King bed plus Twin beds.
            </div>
        </details>

        <!-- FAQ 8 -->
        <details>
            <summary>Can I reserve a swimming pool area for an event?</summary>
            <div class="faq-answer">
                Yes, our poolside area and cabanas can be reserved for private gatherings or events. Please contact our events team at least 7 days in advance for arrangements.
            </div>
        </details>

        <!-- FAQ 9 -->
        <details>
            <summary>Does Audra Haven collaborate with influencers or host promotional events?</summary>
            <div class="faq-answer">
                We occasionally host exclusive promotional events and collaborate with selected partners. For collaboration inquiries, please send a detailed proposal to our marketing team via email.
            </div>
        </details>

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garment Company Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-lg fixed top-0 w-full z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-2xl font-bold text-blue-600">GarmentCo</div>
      <div>
        <a href="/" class="px-4 py-2 text-gray-700 hover:text-blue-600">Home</a>
        <a href="#about" class="px-4 py-2 text-gray-700 hover:text-blue-600">About</a>
        <a href="#products" class="px-4 py-2 text-gray-700 hover:text-blue-600">Products</a>
        <a href="#testimonials" class="px-4 py-2 text-gray-700 hover:text-blue-600">Testimonials</a>
        <a href="#faq" class="px-4 py-2 text-gray-700 hover:text-blue-600">FAQ</a>
        <a href="<?= base_url('admin/dashboard'); ?>" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="relative bg-cover bg-center h-[600px] mt-16" style="background-image: url('https://source.unsplash.com/1600x900/?fashion,clothes')">
    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
      <div class="text-center text-white px-6">
        <h1 class="text-5xl font-extrabold mb-4 animate-pulse">Garment Company</h1>
        <p class="text-xl mb-6">Innovating Fashion with Quality & Style</p>
        <a href="#products" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Explore Products</a>
      </div>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="py-20 max-w-6xl mx-auto px-6">
    <h2 class="text-4xl font-bold mb-8 text-center text-blue-600">About Us</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <img src="https://source.unsplash.com/600x400/?garment,factory" class="rounded-lg shadow-lg">
      <p class="text-gray-700 leading-relaxed text-lg">
        With over 20 years of experience, GarmentCo has been a trusted manufacturer of high-quality apparel for global markets. 
        Our mission is to merge comfort, durability, and style in every product. 
        We prioritize sustainability, innovation, and customer satisfaction, making us a reliable partner in the fashion industry.
      </p>
    </div>
  </section>

  <!-- Products -->
  <section id="products" class="py-20 bg-gray-100">
    <div class="max-w-6xl mx-auto px-6">
      <h2 class="text-4xl font-bold mb-12 text-center text-blue-600">Our Products</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-xl transition">
          <img src="https://source.unsplash.com/400x300/?tshirt" class="w-full h-56 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">T-Shirts</h3>
            <p class="text-gray-600">Premium cotton t-shirts with modern designs for casual wear.</p>
          </div>
        </div>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-xl transition">
          <img src="https://source.unsplash.com/400x300/?jacket" class="w-full h-56 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">Jackets</h3>
            <p class="text-gray-600">Durable jackets with style, perfect for any season.</p>
          </div>
        </div>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden transform hover:-translate-y-2 hover:shadow-xl transition">
          <img src="https://source.unsplash.com/400x300/?jeans" class="w-full h-56 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold mb-2">Jeans</h3>
            <p class="text-gray-600">Trendy jeans designed for both comfort and elegance.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="py-20 max-w-6xl mx-auto px-6">
    <h2 class="text-4xl font-bold mb-12 text-center text-blue-600">What Our Clients Say</h2>

    <!-- Testimonial List -->
    <div id="testimonial-list" class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white shadow-lg rounded-lg p-6">
        <p class="text-gray-600 italic">"GarmentCo delivers top-quality apparel. Their t-shirts are durable and stylish!"</p>
        <div class="mt-4 font-bold">- John D.</div>
      </div>
      <div class="bg-white shadow-lg rounded-lg p-6">
        <p class="text-gray-600 italic">"The jackets are perfect for our winter collection. Customers love them!"</p>
        <div class="mt-4 font-bold">- Maria S.</div>
      </div>
      <div class="bg-white shadow-lg rounded-lg p-6">
        <p class="text-gray-600 italic">"Excellent service and timely delivery. Highly recommended!"</p>
        <div class="mt-4 font-bold">- Alex P.</div>
      </div>
    </div>

    <!-- Add Testimonial Form -->
    <div class="mt-12 max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg">
      <h3 class="text-xl font-bold mb-4 text-blue-600 text-center">Add Your Testimonial</h3>
      <form id="testimonial-form" class="space-y-4">
        <input type="text" id="name" placeholder="Your Name" class="w-full p-3 border rounded-lg" required>
        <textarea id="message" placeholder="Your Message" class="w-full p-3 border rounded-lg" required></textarea>
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">Submit</button>
      </form>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq" class="py-20 bg-gray-100">
    <div class="max-w-4xl mx-auto px-6">
      <h2 class="text-4xl font-bold mb-12 text-center text-blue-600">Frequently Asked Questions</h2>
      <div x-data="{open:null}" class="space-y-4">
        <div class="bg-white shadow-lg rounded-lg p-4 cursor-pointer" @click="open = open === 1 ? null : 1">
          <h3 class="font-semibold">Do you provide custom designs?</h3>
          <p x-show="open === 1" class="mt-2 text-gray-600">Yes, we offer customization services to match your brand needs.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-4 cursor-pointer" @click="open = open === 2 ? null : 2">
          <h3 class="font-semibold">What is your minimum order quantity?</h3>
          <p x-show="open === 2" class="mt-2 text-gray-600">Our MOQ depends on the product category, typically starting at 100 pcs.</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-4 cursor-pointer" @click="open = open === 3 ? null : 3">
          <h3 class="font-semibold">Do you export internationally?</h3>
          <p x-show="open === 3" class="mt-2 text-gray-600">Yes, we ship worldwide with reliable logistics partners.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="py-20 max-w-6xl mx-auto px-6">
    <h2 class="text-4xl font-bold mb-8 text-center text-blue-600">Contact Us</h2>
    <p class="text-gray-600 text-center mb-8">Reach out for business inquiries and partnerships.</p>
    <div class="flex justify-center">
      <form class="w-full md:w-1/2 bg-white p-6 shadow-lg rounded-lg">
        <input type="text" placeholder="Name" class="w-full mb-4 p-3 border rounded-lg">
        <input type="email" placeholder="Email" class="w-full mb-4 p-3 border rounded-lg">
        <textarea placeholder="Message" class="w-full mb-4 p-3 border rounded-lg"></textarea>
        <button class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700">Send Message</button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-8 text-center">
    <p>&copy; <?= date('Y'); ?> Garment Company. All Rights Reserved.</p>
    <p class="text-gray-400 mt-2">Designed with Aji Prima Saputra</p>
  </footer>

  <!-- Script untuk Tambah Testimonial -->
  <script>
    document.getElementById("testimonial-form").addEventListener("submit", function(e) {
      e.preventDefault();

      const name = document.getElementById("name").value;
      const message = document.getElementById("message").value;

      // Buat elemen testimonial baruaaaaa
      const newTestimonial = document.createElement("div");
      newTestimonial.className = "bg-white shadow-lg rounded-lg p-6";
      newTestimonial.innerHTML = `
        <p class="text-gray-600 italic">"${message}"</p>
        <div class="mt-4 font-bold">- ${name}</div>
      `;

      // Masukkan testimonial terbaru di urutan pertama
      const list = document.getElementById("testimonial-list");
      list.insertBefore(newTestimonial, list.firstChild);

      // Reset form
      document.getElementById("testimonial-form").reset();
    });
  </script>

</body>
</html>

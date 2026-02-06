<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Katalog Gitar</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
        }

        .greeting {
            margin-top: 20px;
        }

        .products {
            margin: 30px 0;
        }

        .product-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #3498db;
        }

        .product-name {
            font-weight: bold;
            color: #2c3e50;
            margin: 0 0 5px 0;
        }

        .product-price {
            color: #27ae60;
            font-size: 1.1em;
            font-weight: bold;
        }

        .product-category {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        .cta-button {
            display: inline-block;
            background-color: #3498db;
            color: #ffffff;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            color: #7f8c8d;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎸 Katalog Gitar</h1>
            <p>Newsletter Mingguan</p>
        </div>

        <div class="greeting">
            <p>Halo <strong>{{ $user->username }}</strong>! 👋</p>
            <p>Kami harap Anda dalam keadaan baik. Berikut adalah koleksi gitar terbaru yang mungkin menarik perhatian
                Anda:</p>
        </div>

        <div class="products">
            <h2>🆕 Produk Terbaru</h2>

            @forelse($products as $product)
                <div class="product-card">
                    <p class="product-name">{{ $product->name }}</p>
                    <p class="product-category">Kategori: {{ $product->category->name ?? 'Umum' }}</p>
                    <p class="product-price">{{ $product->formatted_price }}</p>
                </div>
            @empty
                <p>Belum ada produk baru minggu ini.</p>
            @endforelse
        </div>

        <div style="text-align: center;">
            <a href="{{ config('app.url') }}" class="cta-button">
                Lihat Katalog Lengkap →
            </a>
        </div>

        <div class="footer">
            <p>Terima kasih telah menjadi pelanggan setia kami! 🙏</p>
            <p>Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>
            <p style="margin-top: 15px; font-size: 0.8em;">
                &copy; {{ date('Y') }} Katalog Gitar. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
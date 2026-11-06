<rss version="2.0">
    <channel>
        <title>Berita YISI</title>
        <link>{{ route('news.index') }}</link>
        <description>Kabar, pembelajaran, dan cerita lapangan Yayasan Investasi Sosial Indonesia.</description>
        <language>id-ID</language>
        @foreach ($posts as $post)
            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('news.show', $post) }}</link>
                <guid>{{ route('news.show', $post) }}</guid>
                <pubDate>{{ $post->published_at?->toRfc2822String() }}</pubDate>
                <description>{{ $post->excerpt }}</description>
            </item>
        @endforeach
    </channel>
</rss>

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><lastmod>{{ now()->toAtomString() }}</lastmod></url>
    @foreach ($projects as $project)<url><loc>{{ route('projects.show', $project->slug) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>@endforeach
</urlset>

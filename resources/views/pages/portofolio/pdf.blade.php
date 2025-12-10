<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - {{ $user->name }}</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3b82f6; padding-bottom: 20px; }
        .avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; }
        .name { font-size: 24px; font-weight: bold; margin: 0; color: #1e293b; }
        .title { font-size: 14px; color: #3b82f6; margin: 5px 0; font-weight: bold; text-transform: uppercase; }
        .contact { font-size: 12px; color: #64748b; margin-top: 5px; }

        .section { margin-bottom: 25px; clear: both; }
        .section-title { font-size: 16px; font-weight: bold; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 10px; color: #0f172a; text-transform: uppercase; }

        /* Layout Helper for PDF */
        .row:after { content: ""; display: table; clear: both; }
        .col-left { float: left; width: 65%; padding-right: 20px; }
        .col-right { float: left; width: 30%; }

        /* Skills Badge */
        .skill-badge { display: inline-block; background: #f1f5f9; color: #334155; padding: 4px 8px; border-radius: 4px; font-size: 10px; margin-right: 5px; margin-bottom: 5px; border: 1px solid #cbd5e1; }
        .skill-level { color: #64748b; font-size: 9px; }

        /* Project Item */
        .project-item { margin-bottom: 15px; }
        .project-title { font-weight: bold; font-size: 14px; color: #1e293b; }
        .project-link { font-size: 10px; color: #3b82f6; text-decoration: none; }
        .project-desc { font-size: 12px; color: #475569; margin-top: 2px; }

        /* Certificate Item */
        .cert-item { margin-bottom: 10px; }
        .cert-title { font-weight: bold; font-size: 12px; }
        .cert-issuer { font-size: 10px; color: #64748b; }

        /* Assessment Progress Bar (Pengganti Chart) */
        .progress-container { margin-bottom: 8px; }
        .progress-label { font-size: 11px; font-weight: bold; display: block; margin-bottom: 2px; }
        .progress-bg { background-color: #e2e8f0; height: 6px; width: 100%; border-radius: 3px; }
        .progress-bar { background-color: #3b82f6; height: 6px; border-radius: 3px; }
    </style>
</head>
<body>

    <div class="header">
        {{-- Gunakan public_path jika image lokal, atau src biasa jika remote --}}
        {{-- <img src="{{ public_path('storage/avatar.jpg') }}" class="avatar"> --}}
        <div class="name">{{ $user->name }}</div>
        <div class="title">{{ $user->jabatan ?? 'Fullstack Developer' }}</div>
        <div class="contact">{{ $user->email }} | {{ url('/portfolio/view/' . $user->slug) }}</div>
    </div>

    {{-- Layout 2 Kolom --}}
    <div class="row">

        {{-- Kolom Kiri (Main Content) --}}
        <div class="col-left">
            <div class="section">
                <div class="section-title">About Me</div>
                <p style="font-size: 12px; text-align: justify;">
                    {{ $user->bio ?? 'Tidak ada bio.' }}
                </p>
            </div>

            <div class="section">
                <div class="section-title">Featured Projects</div>
                @foreach($user->projects as $project)
                    <div class="project-item">
                        <div class="project-title">
                            {{ $project->project_title }}
                            @if($project->project_link)
                                <a href="{{ $project->project_link }}" class="project-link"> (Link)</a>
                            @endif
                        </div>
                        <div class="project-desc">{{ $project->description }}</div>
                        <div style="margin-top: 5px;">
                            @foreach($project->tags ?? [] as $tag)
                                <span style="font-size: 9px; color: #64748b; background: #f8fafc; padding: 2px 4px; border: 1px solid #e2e8f0;">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kolom Kanan (Sidebar Info) --}}
        <div class="col-right">

            {{-- Assessment Report (Progress Bar Version) --}}
            @if(count($assessmentDetails) > 0)
            <div class="section">
                <div class="section-title">Assessment</div>
                @foreach($assessmentDetails as $item)
                    <div class="progress-container">
                        <span class="progress-label">{{ $item->category }} ({{ $item->score }}%)</span>
                        <div class="progress-bg">
                            <div class="progress-bar" style="width: {{ $item->score }}%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            {{-- Technical Skills --}}
            @if(count($technicalSkills) > 0)
            <div class="section">
                <div class="section-title">Skills</div>
                @foreach($technicalSkills as $skill)
                    <div class="skill-badge">
                        {{ $skill->name }}
                        <span class="skill-level">• {{ $skill->level }}</span>
                    </div>
                @endforeach
            </div>
            @endif

            {{-- Certificates --}}
            @if($user->certificates->count() > 0)
            <div class="section">
                <div class="section-title">Certificates</div>
                @foreach($user->certificates as $cert)
                    <div class="cert-item">
                        <div class="cert-title">{{ $cert->certificate_title }}</div>
                        <div class="cert-issuer">{{ $cert->issuer_organization }} - {{ \Carbon\Carbon::parse($cert->date_issued)->format('Y') }}</div>
                    </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>

    <div style="text-align: center; margin-top: 50px; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px;">
        Generated by VinixPort on {{ date('d M Y') }}
    </div>

</body>
</html>

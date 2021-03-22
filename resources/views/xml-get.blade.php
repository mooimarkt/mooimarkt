@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<request type="schedule-get" timestamp="{{ $data['date'] }}">
    <merchantid>beforemx</merchantid>
    <scheduleref>{{ $data['ref_elavon'] }}_schedu</scheduleref>
    <sha1hash>@php echo sha1(sha1($data['date'].'.beforemx.'.$data['ref_elavon'].'_schedu').'.gjW2s8lWLe'); @endphp</sha1hash>
</request>
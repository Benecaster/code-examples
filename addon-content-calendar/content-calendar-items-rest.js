// Read and write a show's Content Calendar content items over REST

await apiFetch( {
    path: `/benecaster-content-calendar/v1/shows/${ showId }/items`,
    method: 'POST',
    data: {
        type: 'tweet', type_name: '', title: 'Teaser clip', status: 'planned',
        publish_date: '2026-12-04', publish_time: '09:00', due_date: '2026-12-01', due_time: '',
        cancel_reason: '', content: 'New episode Friday', reference_url: '', attachment_id: 0,
        promotion_notes: '', call_to_action: 'Listen now', notes: '', episode_id: 0,
    },
} );

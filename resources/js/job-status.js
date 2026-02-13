// Get the list of processing job IDs from a global variable set in the Blade template
if (typeof processingJobs !== 'undefined' && processingJobs.length > 0) {
	setInterval(checkJobStatuses, 3000);
	checkJobStatuses();
}

async function checkJobStatuses() {
	const jobsToCheck = [...processingJobs];

	for (const jobId of jobsToCheck) {
		try {
			const response = await fetch(`/make-a-video/${jobId}/status`, {
				headers: {
					"X-Requested-With": "XMLHttpRequest",
					Accept: "application/json",
				},
			});

			if (!response.ok) continue;

			const data = await response.json();

			// Update the UI
			updateJobCard(jobId, data);

			if (data.status === "completed" || data.status === "failed") {
				const index = processingJobs.indexOf(jobId);
				if (index > -1) processingJobs.splice(index, 1);

				// Trigger session flash for success or error
				try {
					await fetch(
						`/make-a-video/${jobId}/notify-completion`,
						{
							method: "POST",
							headers: {
								"X-CSRF-TOKEN": document.querySelector(
									'meta[name="csrf-token"]'
								).content,
								"X-Requested-With": "XMLHttpRequest",
							},
						}
					);
				} catch (e) {
					console.error("Notify failed", e);
				}

				// Reload to show the flash message and update UI (thumbnails etc)
				if (processingJobs.length === 0) {
					setTimeout(() => location.reload(), 500);
				}
			}
		} catch (error) {
			console.error(`Error checking job ${jobId}:`, error);
		}
	}
}

function updateJobCard(jobId, data) {
	const card = document.querySelector(`.video-card[data-job-id="${jobId}"]`);
	if (!card) return;

	const statusBadge = card.querySelector(".status-badge");
	if (statusBadge) {
		let badgeHtml = "";
		if (data.status === "pending") {
			badgeHtml = `
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 shadow-sm">
                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Pending
                </span>`;
		} else if (data.status === "processing") {
			badgeHtml = `
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-blue-500/10 text-blue-400 border border-blue-500/20 shadow-sm">
                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Processing
                </span>`;
		} else if (data.status === "completed") {
			badgeHtml = `
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-sm">
                    Completed
                </span>`;
		} else if (data.status === "failed") {
			badgeHtml = `
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-red-500/10 text-red-400 border border-red-500/20 shadow-sm">
                    Failed
                </span>`;
		}
		statusBadge.innerHTML = badgeHtml;
	}
}

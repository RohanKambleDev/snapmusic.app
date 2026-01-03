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
			updateJobRow(jobId, data);

			if (data.status === "completed" || data.status === "failed") {
				const index = processingJobs.indexOf(jobId);
				if (index > -1) processingJobs.splice(index, 1);

				// If completed, trigger session flash
				if (data.status === "completed") {
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
				}

				// Optional: Reload if all done to refresh links?
				if (processingJobs.length === 0) {
					setTimeout(() => location.reload(), 500);
				}
			}
		} catch (error) {
			console.error(`Error checking job ${jobId}:`, error);
		}
	}
}

function updateJobRow(jobId, data) {
	const row = document.querySelector(`tr[data-job-id="${jobId}"]`);
	if (!row) return;

	const statusCell = row.querySelector(".status-badge");
	if (statusCell) {
		let badgeHtml = "";
		if (data.status === "pending") {
			badgeHtml =
				'<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-500/10 text-yellow-300 border border-yellow-500/20">Pending</span>';
		} else if (data.status === "processing") {
			badgeHtml =
				'<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-500/10 text-blue-300 border border-blue-500/20">Processing</span>';
		} else if (data.status === "completed") {
			badgeHtml =
				'<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">Completed</span>';
		} else if (data.status === "failed") {
			badgeHtml =
				'<span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-red-500/10 text-red-300 border border-red-500/20">Failed</span>';
		}
		statusCell.innerHTML = badgeHtml;
	}

	// Note: Actions update logic similar to index-bak could be added here
	// For brevity, relying on reload for full action buttons update
}

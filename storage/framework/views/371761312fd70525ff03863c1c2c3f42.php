<!DOCTYPE html>
<html lang="en">

<?php $__env->startSection('title'); ?>
Complaints - Admin Panel
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.includes.headlinks', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php
$currentTab = request()->query('tab', 'pending'); // default to pending
$complaints = $currentTab === 'pending' ? $pending : $others;
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <?php echo $__env->make('admin.includes.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.includes.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Complaints</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card card-danger card-outline">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pending-tab" data-toggle="pill" href="#pending" role="tab" aria-controls="pending" aria-selected="true"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;Pending</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="others-tab" data-toggle="pill" href="#others" role="tab" aria-controls="others" aria-selected="false"><i class="fa fa-ban"></i>&nbsp;&nbsp;Others</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">

                                    <?php echo $__env->make('includes.success', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">

                                        <a href="<?php echo e(route('finish.complaints')); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to mark all pending complaints as no valid? This action cannot be undone.')">
                                                    <i class="fas fa-undo"></i> No Valid Complaints
                                                </a>
                                                <br><br>

                                            <table class="table table-bordered table-hover table-striped mb-0">
                                                <thead class="thead-dark">
                                                     <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Subject & Detail</th>
                                                        <th>Status</th>
                                                        <th>Admin Reply</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                     </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($complaint->id); ?></td>

                                                        <td>
                                                            <?php if($complaint->user): ?>
                                                            <a target="_blank" href="<?php echo e(route('userDetails', ['id' => $complaint->user->id])); ?>">
                                                                <small class="d-block text-muted">ID: <?php echo e($complaint->user->id); ?></small>
                                                                <?php echo e($complaint->user->username ?? 'N/A'); ?> <br>
                                                                <?php echo e($complaint->user->phone ?? 'N/A'); ?>

                                                            </a>
                                                            <?php else: ?>
                                                            <span class="text-muted">— (Deleted User)</span>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td>
                                                            <strong><?php echo e($complaint->subject); ?></strong>
                                                            <div class="text-muted small mt-1">
                                                                <?php echo e($complaint->detail); ?>

                                                            </div>
                                                            <?php if($complaint->screenshot): ?>
                                                            <a href="<?php echo e(asset($complaint->screenshot)); ?>" target="_blank">
                                                                View Attachment
                                                            </a>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td>
                                                            <span class="badge
                                                    <?php echo e($complaint->status === 'pending'     ? 'badge-warning'  : ''); ?>

                                                    <?php echo e($complaint->status === 'in_progress' ? 'badge-info'     : ''); ?>

                                                    <?php echo e($complaint->status === 'resolved'    ? 'badge-success'  : ''); ?>

                                                    <?php echo e($complaint->status === 'rejected'    ? 'badge-danger'   : ''); ?>

                                                    <?php echo e($complaint->status === 'not_valid'   ? 'badge-secondary': ''); ?>">
                                                                <?php echo e(ucfirst(str_replace('_', ' ', $complaint->status))); ?>

                                                            </span>
                                                        </td>

                                                        <td class="text-muted small">
                                                            <?php echo e($complaint->admin_reply ?? '--'); ?>

                                                            <?php if($complaint->attachments): ?>
                                                            <a href="<?php echo e(asset($complaint->attachments)); ?>" target="_blank" rel="noopener noreferrer">View Attachment</a>
                                                            <?php endif; ?>
                                                        </td>


                                                        <td><?php echo e($complaint->created_at->format('d M Y h:i A')); ?></td>

                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary reply-btn"
                                                                data-toggle="modal"
                                                                data-target="#replyModal"
                                                                data-id="<?php echo e($complaint->id); ?>"
                                                                data-status="<?php echo e($complaint->status); ?>"
                                                                data-reply="<?php echo e(addslashes($complaint->admin_reply ?? '')); ?>">
                                                                Reply / Update
                                                            </button>

                                                            <!-- Delete Button -->
                                                            <form action="<?php echo e(route('admin.complaints.destroy', $complaint->id)); ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this complaint? This action cannot be undone.')">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted py-5">
                                                            No complaints found in this category
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>


                                        <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="others-tab">
                                            <table class="table table-bordered table-hover table-striped mb-0">
                                                <thead class="thead-dark">
                                                     <tr>
                                                        <th>#</th>
                                                        <th>User</th>
                                                        <th>Subject & Detail</th>
                                                        <th>Status</th>
                                                        <th>Admin Reply</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                     </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $others; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <tr>
                                                        <td><?php echo e($complaint->id); ?></td>

                                                        <td>
                                                            <?php if($complaint->user): ?>
                                                            <a target="_blank" href="<?php echo e(route('userDetails', ['id' => $complaint->user->id])); ?>">
                                                                <small class="d-block text-muted">ID: <?php echo e($complaint->user->id); ?></small>
                                                                <?php echo e($complaint->user->username ?? 'N/A'); ?> <br>
                                                                <?php echo e($complaint->user->phone ?? 'N/A'); ?>

                                                            </a>
                                                            <?php else: ?>
                                                            <span class="text-muted">— (Deleted User)</span>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td>
                                                            <strong><?php echo e($complaint->subject); ?></strong>
                                                            <div class="text-muted small mt-1">
                                                                <?php echo e($complaint->detail); ?>

                                                            </div>
                                                            <?php if($complaint->screenshot): ?>
                                                            <a href="<?php echo e(asset($complaint->screenshot)); ?>" target="_blank" rel="noopener noreferrer">View Attachment</a>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td>
                                                            <span class="badge
                                                    <?php echo e($complaint->status === 'pending'     ? 'badge-warning'  : ''); ?>

                                                    <?php echo e($complaint->status === 'in_progress' ? 'badge-info'     : ''); ?>

                                                    <?php echo e($complaint->status === 'resolved'    ? 'badge-success'  : ''); ?>

                                                    <?php echo e($complaint->status === 'rejected'    ? 'badge-danger'   : ''); ?>

                                                    <?php echo e($complaint->status === 'not_valid'   ? 'badge-secondary': ''); ?>">
                                                                <?php echo e(ucfirst(str_replace('_', ' ', $complaint->status))); ?>

                                                            </span>
                                                        </td>

                                                        <td>
                                                            <div class="text-muted small mt-1">
                                                                <?php echo e($complaint->admin_reply ?? '--'); ?>

                                                            </div>
                                                            <?php if($complaint->attachments): ?>
                                                            <a href="<?php echo e(asset($complaint->attachments)); ?>" target="_blank" rel="noopener noreferrer">View Attachment</a>
                                                            <?php endif; ?>
                                                        </td>



                                                        <td><?php echo e($complaint->created_at->format('d M Y h:i A')); ?></td>

                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary reply-btn"
                                                                data-toggle="modal"
                                                                data-target="#replyModal"
                                                                data-id="<?php echo e($complaint->id); ?>"
                                                                data-status="<?php echo e($complaint->status); ?>"
                                                                data-reply="<?php echo e(addslashes($complaint->admin_reply ?? '')); ?>">
                                                                Reply / Update
                                                            </button>

                                                            <!-- Delete Button -->
                                                            <form action="<?php echo e(route('admin.complaints.destroy', $complaint->id)); ?>" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this complaint? This action cannot be undone.')">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted py-5">
                                                            No complaints found in this category
                                                        </td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
            </section>
        </div>


        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">
                            Reply to Complaint #<span id="modalComplaintId"></span>
                        </h5>
                        <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close">X</button>
                    </div>

                    <form action="<?php echo e(route('admin.complaints.update')); ?>" method="POST" enctype="multipart/form-data" id="replyForm">
                        <?php echo csrf_field(); ?>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="modalIdField">

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="modalStatus" class="form-control" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="not_valid">Not Valid</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="admin_reply" class="form-label">Admin Reply / Resolution Note</label>
                                <textarea name="admin_reply" id="modalReply" class="form-control" rows="4"
                                    placeholder="Enter your reply or resolution details..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attach Screenshot / Files (optional)</label>
                                <input type="file" name="attachment" id="attachments" class="form-control" multiple accept="image/*,.pdf">
                                <small class="text-muted">You can select multiple files (images, pdfs)</small>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Complaint</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const replyButtons = document.querySelectorAll('.reply-btn');

    replyButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Get data attributes from the clicked button
            const complaintId   = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            const currentReply  = this.getAttribute('data-reply');

            // Fill modal fields
            document.getElementById('modalComplaintId').textContent = complaintId;
            document.getElementById('modalIdField').value = complaintId;
            document.getElementById('modalStatus').value = currentStatus;
            document.getElementById('modalReply').value  = currentReply || '';
        });
    });

});
</script>

        <?php echo $__env->make('admin.includes.version', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <?php echo $__env->make('admin.includes.footer_links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html><?php /**PATH E:\xampp\htdocs\zipGo\resources\views/admin/complaints.blade.php ENDPATH**/ ?>
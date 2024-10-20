<?php
class GenericExecutorService {
    private array $workers = [];
    private int $maxWorkers;

    public function __construct(int $maxWorkers = 5) {
        $this->maxWorkers = $maxWorkers;
    }

    public function submit(callable $task) {
        if (count($this->workers) < $this->maxWorkers) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                // Fork failed
                die('Could not fork process');
            } elseif ($pid) {
                // Parent process
                $this->workers[$pid] = $task;
            } else {
                // Child process
                $task();
                exit(0); // End the child process after task execution
            }
        } else {
            echo "Max workers reached, unable to submit new task.\n";
        }
    }

    public function shutdown() {
        foreach ($this->workers as $pid => $task) {
            pcntl_waitpid($pid, $status); // Wait for the child process to finish
            unset($this->workers[$pid]);  // Remove from worker pool
        }
    }
}
?>


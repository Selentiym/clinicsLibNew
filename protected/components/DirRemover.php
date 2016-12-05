<?php
	class DirRemover{
		public static function removeDirectory($dir) {
			if ($files = glob($dir . DIRECTORY_SEPARATOR . '*')) {
				foreach ($files as $_file) {
					is_dir($_file) ? self::removeDirectory($_file) : unlink($_file);
				}
			}
			rmdir($dir);
		}
	}
?>
<?php

class Tx_Asdis_Uri_NormalizationService {

	/**
	 * Makes a path relative to the webroot.
	 *
	 * @param string $path                The path.
	 * @param string $referenceOrigin    A file path or directory from which the
	 *                                    file defined by $path is referenced from.
	 * @return string
	 */
	public function normalizePath($path, $referenceOrigin = '') {

		$path            = (string)$path;
		$referenceOrigin = (string)$referenceOrigin;
		$normalizedPath  = '';

		// Remove " and '
		$path = str_replace("\"", "", str_replace("'", "", $path));

		if ($this->containsProtocol($path)) {
			if ($this->urlPointsToThisSite($path)) {
				$normalizedPath = str_replace($this->getSiteUrl(), "", $path);
			} else {
				$normalizedPath = $path;
			}
		} else {

			if (strpos($path, "/") === 0) {
				$normalizedPath = substr($path, 1);
			} else {
				if (strpos($path, "./") === 0) {
					$path = str_replace("./", "", $path);
				}

				// calculate path dependent on origin
				if ($referenceOrigin !== '') {

					$path = str_replace(
						$this->getEqualPartOfPaths($path, $referenceOrigin),
						"",
						$path
					);

					$numDirsUp = substr_count($path, "../");

					$origin = $this->bubbleUpstairs(
						$this->normalizePath($referenceOrigin),
						$numDirsUp
					);

					$path = str_replace("../", "", $path);

					$normalizedPath = $origin . '/' . $path;

					// can't do anything because there's no origin
				} else {
					$normalizedPath = str_replace(
						$this->getPathToWebRoot(),
						"",
						$path
					);
				}

				// remove leading slash
				if ($this->isAbsoluteFilesystemPath($normalizedPath)) {
					$normalizedPath = substr($normalizedPath, 1);
				}
			}
		}

		// remove ".." inside the path
		if (strpos($normalizedPath, "..") !== FALSE) {
			$normalizedPath = str_replace($this->getPathToWebRoot(), "", realpath($normalizedPath));
		}

		return $normalizedPath;
	}

	/**
	 * Returns a part of the path of both paths which is the same in both.
	 * For example, if you pass "fileadmin/templates/css/style.css" and
	 * "fileadmin/templates/images/icon.png" the method will return
	 * "fileadmin/templates/".
	 *
	 * @param string $path1
	 * @param string $path2
	 * @return string
	 */
	public function getEqualPartOfPaths($path1, $path2) {

		$path1      = (string)$path1;
		$path2      = (string)$path2;
		$maxLength  = min(array(strlen($path1), strlen($path2)));
		$currentPos = 0;
		$matched    = TRUE;

		while ($currentPos < $maxLength && $matched === TRUE) {
			if (substr($path1, $currentPos, 1) != substr($path2, $currentPos, 1)) {
				$matched = FALSE;
			} else {
				$currentPos++;
			}
		}

		return substr($path1, 0, $currentPos);
	}

	/**
	 * Makes each path of a list of paths relative to the webroot.
	 *
	 * @param array    $paths The paths.
	 * @return array
	 */
	public function normalizePaths(array $paths) {

		if (sizeof($paths) > 0) {
			foreach ($paths as $key => $path) {
				$paths[$key] = $this->normalizePath($path);
			}
		}

		return $paths;
	}

	/**
	 * Bubbles up the directory path for a given file or directory.
	 * Ensure you append a slash if $path is a directory. This is
	 * because it is not checked if the file/directory exists.
	 * Example: ($path="/var/www/htdocs/", 2) = "/var" while
	 *          ($path="/var/www/htdocs", 2)  = "/".
	 *
	 * @param string    $path
	 * @param integer    $numberOfSteps
	 * @return void
	 */
	public function bubbleUpstairs($path, $numberOfSteps) {

		$rPos               = strrpos($path, '/');
		$canTakeOneMoreStep = $rPos !== 0 && $rPos !== FALSE ? TRUE : FALSE;

		while ($canTakeOneMoreStep && $numberOfSteps >= 0) {

			$path               = substr($path, 0, strrpos($path, "/"));
			$rPos               = strrpos($path, "/");
			$canTakeOneMoreStep = $rPos !== 0 && $rPos !== FALSE ? TRUE : FALSE;
			$numberOfSteps--;
		}

		return $path;
	}

	/**
	 * Checks of an url defined by the given path points to this site.
	 *
	 * @param string $path
	 * @return boolean
	 */
	public function urlPointsToThisSite($path) {
		return (strpos($this->stripProtocol($path), $this->stripProtocol($this->getSiteUrl())) !== FALSE);
	}

	/**
	 * Tells whether the given path is absolute or not.
	 * This means that the path starts with "/" or not.
	 *
	 * @param string $path
	 * @return boolean
	 */
	public function isAbsoluteFilesystemPath($path) {
		return (strpos($path, "/") === 0);
	}

	/**
	 * Returns the URL of the site root.
	 * E.g. "http://www.mysite.com/".
	 *
	 * @return string
	 */
	public function getSiteUrl() {
		return t3lib_div::getIndpEnv('TYPO3_SITE_URL');
	}

	/**
	 * Tells if the given path contains the HTTP or HTTPS prototcol.
	 *
	 * @param string $path
	 * @return boolean
	 */
	public function containsProtocol($path) {
		return (
				strpos($path, "http://") !== FALSE ||
						strpos($path, "https://") !== FALSE
		);
	}

	/**
	 * Removes "http://" and "https://" from the given path.
	 *
	 * @param string $path
	 * @return string
	 */
	protected function stripProtocol($path) {
		return str_replace("http://", "", str_replace("https://", "", $path));
	}

	/**
	 * Tells if a file described by the given path exists.
	 *
	 * @param string $path
	 * @return boolean
	 */
	public function fileExists($path, $lossy = TRUE) {

		$path   = (string)$path;
		$exists = FALSE;

		$exists = file_exists($path);

		// if not exists try again with normalized path
		if (!$exists && $lossy) {
			$path   = $this->getPathToWebRoot() . '/' . $this->normalizePath($path);
			$exists = file_exists($path);
		}

		return $exists;
	}

	/**
	 * Returns the content of the file with the given path.
	 *
	 * @param string $path
	 * @return string
	 */
	public function getFileContent($path) {

		$content = '';

		if ($this->fileExists($path)) {
			$content = file_get_contents(
				$this->getPathToWebRoot() . '/' . $this->normalizePath($path)
			);
		}

		return $content;
	}

	/**
	 * Returns the absolute path to the TYPO3 main dir in the filesystem.
	 *
	 * @return string
	 */
	public function getPathToWebRoot() {
		return realpath(PATH_site) . '/';
	}

	/**
	 * Returns the timestamp of the last modification of the file described by
	 * the given path.
	 * If the file doesn't exist, the method will return 0.
	 *
	 * @param string $path
	 * @return integer
	 */
	public function getLastModificationTimestampOfFile($path) {

		$timestamp    = 0;
		$absolutePath = $this->getPathToWebRoot() . $path;

		if (file_exists($absolutePath)) {
			$timestamp = filemtime($absolutePath);
		}

		if ($timestamp === FALSE) {
			$timestamp = 0;
		}

		return $timestamp;
	}
}
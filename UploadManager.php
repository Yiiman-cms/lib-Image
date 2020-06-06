<?php
	
	
	namespace system\lib;
	
	use BadMethodCallException;
	use Exception;
	use InvalidArgumentException;
	use Yii;
	use yii\db\ActiveRecord;
	use yii\web\UploadedFile;
	use function realpath;
	
	/**
	 * Class UploadManager
	 * @package system\lib
	 */
	class UploadManager {
		public $dir;
		public $model;
		public $attribute;
		public $errors = [];
		private $uploadDir;
		
		public function __construct() {
			$this->uploadDir = Yii::$app->Options->UploadDir . $this->dir;
		}
		
		/**
		 * @param ActiveRecord $model     not empty model
		 * @param string       $attribute your file attribute
		 *
		 * @return string sile name
		 * @throws \yii\base\InvalidConfigException
		 */
		public function save( $model , $attribute ) {
			/**
			 * @var $model \system\modules\testimotional\models\Testimotional
			 */
			if ( ! empty( $_FILES ) ) {
				if ( empty( $this->image ) ) {
					$files    = UploadedFile::getInstance( $model , $attribute );
					$fileName = uniqid() . '.' . $files->extension;
					$dir      = Yii::$app->Options->UploadDir . '/' . $this->getUploadDirectory(
							$model
						) . '/' . $fileName;
					$this->MakeDir( Yii::$app->Options->UploadDir . '/' . $this->getUploadDirectory( $model ) );
					if (!empty( $this->errors)){
						echo '<pre style="direction:ltr">';
						var_dump($this->errors);
						die();
						
					}
					$files->saveAs( $dir );
					
					return $fileName;
				}
			}
		}
		
		/**
		 * this will return folder that file will be upload on that
		 *
		 * @param \yii\db\ActiveRecord $model
		 *
		 * @return string
		 * @throws \yii\base\InvalidConfigException
		 */
		public function getUploadDirectory( $model ) {
			return $dir = $model->formName() . '/' . $model->id;
		}
		
		private function MakeDir( $dir , $fullPath = true ) {
			$exist = realpath( $dir );
			
			
			if ( empty( $exist ) ) {
				$chunkedDir = explode( '/' , $dir );
				if ( count( $chunkedDir ) > 1 && $fullPath ) {
					$mkDirectory = '';
					foreach ( $chunkedDir as $item ) {
						if ( ! empty( $mkDirectory ) ) {
							$mkDirectory .= '/' . $item;
						} else {
							$mkDirectory = $item;
						}
						$this->MakeDir( $mkDirectory , false );
					}
				} else if ( $fullPath ) {
					throw new BadMethodCallException(
						'Your Upload Directory Settings Is Invalid, Please Set On Settings Menu'
					);
				} else {
					$mkDir=true;
					if (PHP_OS=='Linux'){
						if (empty( realpath( '/'.$dir))){
							
							
							$mkDir=mkdir( '/'.$dir,0775 );
							chmod( '/'.$dir , 0755);
						}
					}else{
						if (empty( realpath( $dir))){
							$mkDir=mkdir( $dir,0755 );
							if (PHP_OS=='Linux'){

                                chmod( '/'.$dir , 0755);
                            }else{
                                chmod( $dir , 0755);
                            }
						}
						
					}
					if (!$mkDir){
						$this->errors[] = ['error in make directory','directory'=>$dir];
					}
				}
			}
		}
		
		private function addError( $key , $content ) {
			$this->errors[] =
				[
					'title'   => $key ,
					'content' => $content
				];
		}
		
		
		public function getImageUrl( $model , $attrName , $size = 'default' ) {
			/* < Variables > */
			{
				$attribute = $model->$attrName;
				
				$options   = Yii::$app->Options;
				$uploadUrl = $options->UploadUrl;
				$uploadDir = $options->UploadDir;
			}
			/* </ Variables > */
			
			/* < calculate image index > */
			{
				
				$image = $attribute;
				
			}
			/* </ calculate image index > */
			
			/* < check validate $image variable > */
			{
				if ( empty( $image ) ) {
					return $this->generateNoImage($size);
				}
			}
			/* </ check validate $image variable > */
			
			
			/* < check image is exist in public upload folder? > */
			{
				$uploadPath = Yii::$app->Options->UploadDir . '/' . $this->getUploadDirectory( $model );
				$exist      = realpath( $uploadPath );
				if ( $exist ) {
					
					/* < Check Generation Size > */
					{
						$url = $uploadUrl . '/' . $this->getUploadDirectory( $model ) . '/' . $image;
						$dir = $uploadDir . '/' . $this->getUploadDirectory( $model );
						if ( ! empty( $size ) ) {
							if ( $size == 'default' ) {
								return $url;
							} else {
								$sizeText = $size;
								$size     = str_replace( [ '*' , ' ' , '.' , ',' ] , '*' , $size );
								$size     = explode( '*' , $size );
								if ( ! empty( $size ) ) {
									/* < Split Size > */
									{
										$width = $size[0];
										$heiht = $size[1];
									}
									/* </ Split Size > */
									
									/* < Goto Private Upload Directory > */
									{
										/* < parse image name > */
										{
											$folderAddress = $dir . '/' . $width . '_' . $heiht;
											$fileAddress   = $uploadUrl . '/' . $this->getUploadDirectory(
													$model
												) . '/' . $width . '_' . $heiht . '/' . $image;
											
											/* < Image name folder extraction > */
											{
												if ( ! realpath( $folderAddress ) ) {
													@mkdir( $folderAddress );
												}
												
											}
											/* </ Image name folder extraction > */
											
											
											if ( ! realpath( $fileAddress ) ) {
												
												Yii::$app->ImageManager->make( $dir . '/' . $image )->resize(
													$width ,
													$heiht
												)->save( $dir . '/' . $width . '_' . $heiht . '/' . $image , 100 );
											}

//
											return $uploadUrl . '/' . $this->getUploadDirectory(
													$model
												) . '/' . $width . '_' . $heiht . '/' . $image;
										}
										/* </ parse image name > */
									}
									/* </ Goto Private Upload Directory > */
									
								} else {
									return $url;
								}
							}
						} else {
							return $url;
						}
						
						
					}
					/* </ Check Generation Size > */
				} else {
					return $this->generateNoImage($size);
				}
			}
			/* </ check image is exist in public upload folder? > */
			
		}
		
		private function generateNoImage($size = 'default',$image='noImage.jpg'){
			$uploadPath =Yii::$app->Options->UploadDir . '/images/noImage.jpg';
			$exist      = realpath( $uploadPath );
			if ( $exist ) {
				
				/* < Check Generation Size > */
				{
					$url = Yii::$app->Options->UploadUrl . '/images/noImage.jpg';
					$dir = Yii::$app->Options->UploadDir . '/images/noImage.jpg';
					if ( ! empty( $size ) ) {
						if ( $size == 'default' ) {
							return $url;
						} else {
							$size     = str_replace( [ '*' , ' ' , '.' , ',' ] , '*' , $size );
							$size     = explode( '*' , $size );
							if ( ! empty( $size ) ) {
								/* < Split Size > */
								{
									$width = $size[0];
									$heiht = $size[1];
								}
								/* </ Split Size > */
								
								/* < Goto Private Upload Directory > */
								{
									/* < parse image name > */
									{
										$folderAddress = Yii::$app->Options->UploadDir . '/images/' . $width . '_' . $heiht;
										$fileAddress   = $folderAddress . '/'  . $image;
										
										/* < Image name folder extraction > */
										{
											if ( ! realpath( $folderAddress ) ) {
												@mkdir( $folderAddress );
											}
											
										}
										/* </ Image name folder extraction > */
										
										
										if ( ! realpath( $fileAddress ) ) {
											
											Yii::$app->ImageManager->make( $dir  )->resize(
												$width ,
												$heiht
											)->save( $fileAddress , 100 );
										}

//
										return Yii::$app->Options->URL.'/'.Yii::$app->Options->UploadUrl. '/images/' . $width . '_' . $heiht . '/' . $image;
									}
									/* </ parse image name > */
								}
								/* </ Goto Private Upload Directory > */
								
							} else {
								return $url;
							}
						}
					} else {
						return $url;
					}
					
					
				}
				/* </ Check Generation Size > */
			}else{
				$this->MakeDefaultPic(Yii::$app->Options->UploadDir . '/images');
				$this->generateNoImage($size,$image);
			}
		}
		
		public function checkIndex( array $array , int $index ) {
			if ( ! empty( $array[ $index ] ) ) {
				return $array[ $index ];
			} else {
				return $this->checkIndex( $array , ( (integer) $index - 1 ) );
			}
		}
		
		public function deleteDir($dirPath) {
			if (! is_dir($dirPath)) {
				throw new InvalidArgumentException("$dirPath must be a directory");
			}
			if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
				$dirPath .= '/';
			}
			$files = glob($dirPath . '*', GLOB_MARK);
			foreach ($files as $file) {
				if (is_dir($file)) {
					self::deleteDir($file);
				} else {
					unlink($file);
				}
			}
			rmdir($dirPath);
		}
		
		private function MakeDefaultPic($dir){
			if ( ! realpath( $dir ) ) {
				@mkdir( $dir,true );
			}
			$file=fopen( $dir.'/noImage.jpg' , 'w+');
			
			fwrite( $file ,file_get_contents( __DIR__.'/no-image.jpg'));
			fclose( $file);
		}
	}

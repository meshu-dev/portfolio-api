class S3Service
{
	constructor(aws, s3, bucket) {
		this.aws = aws;
		this.s3 = s3;
		this.bucket = bucket;
	}
	verifyCredentials(callback) {
		this.aws.config.getCredentials(callback);
		/*
		this.aws.config.getCredentials(function (err) {
		  if (err) console.log(err.stack)
		  else {
		    console.log("Access key:", this.aws.config.credentials.accessKeyId);
		    console.log("Secret access key:", this.aws.config.credentials.secretAccessKey);
		  }
		}) */
	}
	upload(key, fileStream, callback) {
		let params = {
			Bucket: this.bucket,
			Key: key,
			Body: fileStream,
			ACL: "public-read"
		};
		this.s3.upload(params, callback);
	}
	get(key, callback) {
		let params = {
			Bucket: this.bucket,
			Key: key
		};
		this.s3.getObject(params, callback);
	}
	delete(key, callback) {
		let params = {
			Bucket: this.bucket,
			Key: key
		};
		this.s3.deleteObject(params, callback);
	}
}

module.exports = S3Service

const mongoose = require('mongoose');

let Schema = mongoose.Schema;

let imageSchema = new Schema(
  {
    imageKey: {
      type: String,
      unique: true,
      required: true,
    },
    thumbKey: {
      type: String,
      unique: true,
      required: true,
    },
    imageUrl: {
      type: String,
      unique: true,
      required: true,
    },
    thumbUrl: {
      type: String,
      unique: true,
      required: true,
    },
  },
  {
    timestamps: true,
  }
);

imageSchema.set('toJSON', {
  versionKey: false,
});

imageSchema.options.toJSON.transform = (doc, ret) => {
  ret.createdAt = new Date(ret.createdAt).toString();
  ret.updatedAt = new Date(ret.updatedAt).toString();

  let idObj = {id: ret._id};
  delete ret._id;

  return Object.assign({}, idObj, ret);
};

module.exports = mongoose.model('Image', imageSchema);

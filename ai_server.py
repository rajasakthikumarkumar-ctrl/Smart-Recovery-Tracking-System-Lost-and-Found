
from flask import Flask, request, jsonify
from tensorflow.keras.applications.mobilenet_v2 import MobileNetV2, decode_predictions, preprocess_input
from tensorflow.keras.preprocessing import image
import numpy as np, io

app = Flask(__name__)
model = MobileNetV2(weights='imagenet')

@app.route('/predict', methods=['POST'])
def predict():
    if 'file' not in request.files:
        return jsonify({'error':'no file provided'}), 400
    f = request.files['file']
    try:
        img = image.load_img(io.BytesIO(f.read()), target_size=(224, 224))
        x = image.img_to_array(img)
        x = np.expand_dims(x, axis=0)
        x = preprocess_input(x)
        preds = model.predict(x)
        label = decode_predictions(preds, top=1)[0][0][1]
        return jsonify({'category': label})
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)

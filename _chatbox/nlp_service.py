import sys
import json
from transformers import pipeline

def analyze_message(message):
    nlp = pipeline("ner", model="dbmdz/bert-large-cased-finetuned-conll03-english")
    ner_results = nlp(message)
    
    intent = "unknown"
    entities = {}

    if "課程" in message or "課程詳情" in message:
        intent = "course_info"
        course_name = ""
        for entity in ner_results:
            if entity['entity'] == 'B-MISC':
                course_name += entity['word'] + " "
        entities['course_name'] = course_name.strip()
    
    return intent, entities

if __name__ == "__main__":
    if len(sys.argv) > 1:
        user_message = sys.argv[1]
    else:
        user_message = "測試消息"  # 默認消息，便於測試

    intent, entities = analyze_message(user_message)
    result = {"intent": intent, "entities": entities}
    print(json.dumps(result))

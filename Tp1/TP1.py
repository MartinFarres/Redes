def main():
    frames_text = get_log_text('./Tramas_802-15-4.log')

    frames_list, total_frames_with_escape_sequence, frames_with_escape_sequence = build_frames_list(frames_text)
    frames_with_correct_length, frames_with_incorrect_length = get_frames_with_correct_and_incorrect_length(frames_list)
    frames_with_correct_checksum, frames_with_incorrect_checksum = get_frames_with_correct_and_incorrect_checksum(frames_with_correct_length)

    print("----------------------------------------------------------")
    print(f"Tramas totales: {len(frames_list)}")
    print(f"Tramas con longitud correcta: {len(frames_with_correct_length)}")
    print(f"Tramas con longitud incorrecta: {len(frames_list) - len(frames_with_correct_length)}")
    print(f"Tramas con longitud correcta y checksum correcto: {len(frames_with_correct_checksum)}")
    print(f"Tramas con longitud correcta y checksum incorrecto: {len(frames_with_incorrect_checksum)}")
    print(f"Tramas que utilizan secuencia de escape: {total_frames_with_escape_sequence}")
    print("----------------------------------------------------------")

    print("Tramas con secuencia de escape, luego de retirarlas:")
    for frame in frames_with_escape_sequence:
        print(frame)

    print("---------------------------------------------------------")
    print("Tramas con longitud incorrecta:")
    for frame in frames_with_incorrect_length:
        print(frame)

    print("---------------------------------------------------------")
    print("Tramas con checksum incorrecto:")
    for frame in frames_with_incorrect_checksum:
        print(frame)



def get_log_text(path):
    with open(path, "r") as file:
        log_content = file.read()
        cleaned_content = log_content.strip()
        return cleaned_content
    
def build_frames_list(log_content):
    frames_list = []
    frames_with_escape_sequence = []
    frame_start = '7E'
    escape_sequence = 0
    has_escape_sequence = False
    start_index = log_content.find(frame_start)
    i = 0

    while start_index != -1:

        end_index = log_content.find(frame_start, start_index + len(frame_start))

        # Check escape sequence
        if log_content[(end_index - 2):end_index+2] == "7D7E":
            end_index = log_content.find(frame_start, end_index + 1)
            escape_sequence += 1
            has_escape_sequence = True

        # Build frame
        if end_index != -1:
            frame = log_content[start_index:end_index]
            if has_escape_sequence:
                escape_sequence_start = frame.find("7D7E")
                frame = frame[:escape_sequence_start] + frame[escape_sequence_start+2:]
                frames_with_escape_sequence.append(f"{i}: {frame}")
            frames_list.append(frame)
        else:
            break

        start_index = log_content.find(frame_start, end_index)
        last_star_index = start_index
        has_escape_sequence = False
        i += 1

    # Build last frame
    last_frame = log_content[last_star_index:]
    frames_list.append(last_frame)
    
    return (frames_list, escape_sequence, frames_with_escape_sequence)

def get_frames_with_correct_and_incorrect_length(frames_list):
    frames_with_correct_length = []
    frames_with_incorrect_length = []
    i = 0
    for frame in frames_list:
        if has_correct_length(frame):
            frames_with_correct_length.append(frame)
        else:
            frames_with_incorrect_length.append(f"{i}: {frame}")
        i+=1
    return frames_with_correct_length, frames_with_incorrect_length


def has_correct_length(frame):
    bytes_list = [int(frame[i:i+2],16) for i in range(0, len(frame), 2)]
    actual_frame_length = len(bytes_list[3:-1])
    frame_length_indicator = bytes_list[2]

    if actual_frame_length == frame_length_indicator:
        return True
    
    return False

def get_frames_with_correct_and_incorrect_checksum(frames_list):
    frames_with_correct_checksum = []
    frames_with_incorrect_checksum = []
    i = 0
    for frame in frames_list:
        if has_correct_checksum(frame):
            frames_with_correct_checksum.append(frame)
        else:
            frames_with_incorrect_checksum.append(f"{i}: {frame}")
        i+= 1
    return frames_with_correct_checksum, frames_with_incorrect_checksum


def has_correct_checksum(frame):
    # Convert hexadecimal frame string into a int list
    bytes_list = [int(frame[i:i+2],16) for i in range(0, len(frame), 2)]
    
    bytes_sum = sum(bytes_list[3:-1])

    checksum = 0xFF - (bytes_sum & 0xFF)

    if checksum == bytes_list[-1]:
        return True

    return False

main()
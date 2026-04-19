CRC8    START 0
. MAIN FLOW
FIRST     JSUB  INIT         .init data
          JSUB  READIN       .read input
          JSUB  COPYBUF      .copy input to another buffer
          JSUB  CRCCALC      .calculate CRC-8
          JSUB  APPENDCRC    .append CRC to input
          JSUB  EMITBUF      .emit the final buffer
MAIN_DONE J     MAIN_DONE     .infinite loop to end the program

. INIT CRC
INIT    LDA     #0
        STA     R   .init CRC register
        RSUB

. READ: length + message
READIN      LDA     #0
READ_LEN    TD      INPUT   .test if device is ready
            JEQ     READ_LEN    
            RD      INPUT       .read length of message
            STA     MSG_LEN     .store length
            LDA     MSG_LEN     
            COMP    #0
            JEQ     READ_DONE   .if length is 0, we're done
            COMP    #MAX_LEN
            JGE     READ_DONE   .if length exceeds max, we're done      

.read message bytes
            LDX #0          .initialize index
READ_LOOP   TD  INPUT
            JEQ READ_LOOP
            RD  INPUT
            STCH M_BUF,X    .store byte in buffer
            TIX MSG_LEN     .increment index and compare with length
            JLT READ_LOOP   .read until we've read the entire message

READ_DONE   RSUB

. COPY M_BUF → MR_BUF
COPYBUF     LDA MSG_LEN
            COMP #0
            JEQ COPY_DONE    .if length is 0, we're done
            COMP #MAX_LEN
            JGE COPY_DONE    .if length exceeds max, we're done
            
            LDX #0          
COPY_LOOP   LDCH M_BUF,X    .load byte from original buffer
            STCH MR_BUF,X   .store byte in new buffer
            TIX MSG_LEN     .increment index and compare with length
            JLT COPY_LOOP   .copy until we've copied the entire message

COPY_DONE   RSUB

. CRC-8 core
CRCCALC     LDA #0
            STA R           .initialize CRC register = 0
            LDX #0           
            LDA MSG_LEN
            COMP #0
            JEQ CRC_DONE     
            COMP #MAX_LEN
            JGE CRC_DONE     .check for valid length

BYTE_LOOP   LDA #0
            LDCH MR_BUF,X   .load each byte of the message
            STA BYTEVAL     .store byte value

            .XOR operation : R XOR BYTEVAL to combine current CRC with byte value
            LDA R
            OR BYTEVAL
            STA XOR_OR      . A OR B
            LDA R
            AND BYTEVAL
            STA XOR_AND     . A AND B
            LDA XOR_OR
            SUB XOR_AND     . (A OR B) - (A AND B) = A XOR B
            STA R           .update CRC register with result

            LDA #8
            STA BIT_POS      .initialize bit position counter
BIT_LOOP    LDA R
            AND MASK_MSB        .check if MSB of CRC is 1
            COMP #0
            JEQ SHIFT_ONLY      .if MSB is 0, just shift    

            LDA R
            SHIFTL A,1          .shift left 1 bit
            AND BYTE_MASK       .mask to 8 bits
            STA R               

            .XOR with polynomial: R XOR POLY
            LDA R
            OR POLY
            STA XOR_OR
            LDA R
            AND POLY
            STA XOR_AND
            LDA XOR_OR
            SUB XOR_AND
            AND BYTE_MASK
            STA R               .update CRC register             

            J NEXT_BIT          .go to next bit

SHIFT_ONLY  LDA R
            SHIFTL A,1          
            AND BYTE_MASK       
            STA R        

NEXT_BIT    LDA BIT_POS
            SUB #1
            STA BIT_POS
            COMP #0
            JGT BIT_LOOP        .repeat for all 8 bits

            TIX MSG_LEN         
            JLT BYTE_LOOP       .repeat for all bytes

CRC_DONE   RSUB     

. APPEND CRC to MR_BUF
APPENDCRC   LDA R
            AND BYTE_MASK
            STA MR_BUF,X        .store CRC at the end of the message
            RSUB

.output buffer
EMITBUF     LDA MSG_LEN
            COMP #0
            JEQ EMIT_DONE      .if length is 0, we're done
            COMP #MAX_LEN
            JGE EMIT_DONE      .if length exceeds max, we're done
            
            LDA MSG_LEN
            ADD #1              .include CRC byte
            STA OUT_LEN        

            LDX #0
EMIT_WAIT   TD OUTPUT
            JEQ EMIT_WAIT       .wait until device is ready
            LDCH MR_BUF,X
            WD OUTPUT           .write each byte to output
            TIX OUT_LEN
            JLT EMIT_WAIT       .emit until we've emitted the entire message + CRC
            RSUB

POLY       BYTE X'07'       .CRC-8 polynomial (x^8 + x^2 + x + 1)
MASK_MSB   BYTE X'80'       .mask to check MSB of CRC
BYTE_MASK  BYTE X'FF'       .mask to keep CRC within 8 bits

INPUT      BYTE X'F1'      
OUTPUT     BYTE X'05'   

R          WORD 0           .CRC register
MSG_LEN    WORD 0           .length of the message
MAX_LEN    EQU 256          .maximum message length
M_BUF      RESB 256         .buffer to hold input message
MR_BUF     RESB 257         .buffer to hold message + CRC
OUT_LEN    WORD 0           .length of output (message + CRC)
BIT_POS    WORD 0           .bit position counter
BYTEVAL    WORD 0           .current byte value

. temporary variables for XOR operations
XOR_OR     WORD 0           
XOR_AND    WORD 0



